<?php

namespace App\Http\Controllers\superAdmin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SuperAdmin\CustomController;
use App\Mail\SendMail;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\DoctorSubscription;
use App\Models\Hospital;
use App\Models\Medicine;
use App\Models\Notification;
use App\Models\NotificationTemplate;
use App\Models\Prescription;
use App\Models\Setting;
use App\Models\Settle;
use App\Models\User;
use App\Models\UserAddress;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use OneSignal;
use PDF;
use Symfony\Component\HttpFoundation\Response;

class AppointmentController extends Controller
{
    public function calendar()
    {
        abort_if(Gate::denies('appointment_calendar_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('superAdmin.appointment.calendar');
    }

    public function inCalendar()
    {
        (new CustomController)->cancel_max_order();
        if (auth()->user()->hasRole('super admin')) {
            $appointments = Appointment::with('user')->get();

            return response(['success' => true, 'data' => $appointments]);
        }
        if (auth()->user()->hasRole('doctor')) {
            $appointments = Appointment::with('user')->get();

            return response(['success' => true, 'data' => $appointments]);
        }
    }

    public function commission()
    {
        (new CustomController)->cancel_max_order();
        abort_if(Gate::denies('commission_details'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $doctor = Doctor::where('user_id', auth()->user()->id)->first();
        $now = Carbon::today(env('timezone'));
        $appointments = [];
        for ($i = 0; $i < 7; $i++) {
            $appointment = Appointment::where('doctor_id', $doctor->id)->whereDate('created_at', $now)->get();
            $appointment['amount'] = $appointment->sum('amount');
            $appointment['admin_commission'] = $appointment->sum('admin_commission');
            $appointment['doctor_commission'] = $appointment->sum('doctor_commission');
            $now = $now->subDay();
            $appointment['date'] = $now->toDateString();
            array_push($appointments, $appointment);
        }

        $currency = Setting::first()->currency_symbol;

        $past = Carbon::now(env('timezone'))->subDays(35);
        $now = Carbon::today(env('timezone'));
        $c = $now->diffInDays($past);
        $loop = $c / 10;
        $data = [];
        while ($now->greaterThan($past)) {
            $t = $past->copy();
            $t->addDay();
            $temp['start'] = $t->toDateString();
            $past->addDays(10);
            if ($past->greaterThan($now)) {
                $temp['end'] = $now->toDateString();
            } else {
                $temp['end'] = $past->toDateString();
            }
            array_push($data, $temp);
        }

        $settels = [];
        $orderIds = [];
        foreach ($data as $key) {
            $settle = Settle::where('doctor_id', $doctor->id)->where('created_at', '>=', $key['start'].' 00.00.00')->where('created_at', '<=', $key['end'].' 23.59.59')->get();
            $value['d_total_task'] = $settle->count();
            $value['admin_earning'] = $settle->sum('admin_amount');
            $value['doctor_earning'] = $settle->sum('doctor_amount');
            $value['d_total_amount'] = $value['admin_earning'] + $value['doctor_earning'];
            $remainingOnline = Settle::where([['doctor_id', $doctor->id], ['payment', 0], ['doctor_status', 0]])->where('created_at', '>=', $key['start'].' 00.00.00')->where('created_at', '<=', $key['end'].' 23.59.59')->get();
            $remainingOffline = Settle::where([['doctor_id', $doctor->id], ['payment', 1], ['doctor_status', 0]])->where('created_at', '>=', $key['start'].' 00.00.00')->where('created_at', '<=', $key['end'].' 23.59.59')->get();

            $online = $remainingOnline->sum('doctor_amount'); // admin e devana
            $offline = $remainingOffline->sum('admin_amount'); // admin e levana

            $value['duration'] = $key['start'].' - '.$key['end'];
            $value['d_balance'] = $offline - $online; // + hoy to levana - devana
            array_push($settels, $value);
        }

        return view('superAdmin.appointment.commission', compact('doctor', 'appointments', 'currency', 'settels'));
    }

    public function show_settlement(Request $request)
    {
        $duration = explode(' - ', $request->duration);
        $currency = Setting::first()->currency_symbol;
        $settle = Settle::where('created_at', '>=', $duration[0].' 00.00.00')->where('created_at', '<=', $duration[1].' 23.59.59')->get();
        foreach ($settle as $s) {
            $s->date = $s->created_at->toDateString();
        }

        return response(['success' => true, 'data' => $settle, 'currency' => $currency]);
    }

    public function acceptAppointment($appointment_id)
    {
        Appointment::find($appointment_id)->update(['appointment_status' => 'approve']);
        $this->notificationChange($appointment_id, 'Accept');

        return redirect()->back()->with('status', __('status change successfully...!!'));
    }

    public function cancelAppointment($appointment_id)
    {
        $appointment = Appointment::find($appointment_id);
        $appointment->update(['appointment_status' => 'cancel']);
        $this->notificationChange($appointment_id, 'Cancel');
        (new CustomController)->cancelScheduledNotification($appointment->scheduled_notification_id_patient, $appointment->scheduled_notification_id_doctor);

        return redirect()->back()->with('status', __('status change successfully...!!'));
    }

    public function completeAppointment($appointment_id)
    {
        $appointment = Appointment::find($appointment_id);
        Appointment::find($appointment_id)->update(['appointment_status' => 'complete', 'payment_status' => 1]);
        $doctor = Doctor::where('user_id', auth()->user()->id)->first();
        if ($doctor->based_on == 'commission') {
            $settle = [];
            $settle['appointment_id'] = $appointment->id;
            $settle['doctor_id'] = $appointment->doctor_id;
            $settle['doctor_amount'] = $appointment->doctor_commission;
            $settle['admin_amount'] = $appointment->admin_commission;
            $settle['payment'] = $appointment->payment_type == 'COD' ? 0 : 1;
            $settle['doctor_status'] = 0;
            Settle::create($settle);
        }
        $this->notificationChange($appointment_id, 'Complete');

        return redirect()->back()->with('status', __('status change successfully...!!'));
    }

    // change Appointment to user
    public function notificationChange($appointment_id, $status)
    {
        $setting = Setting::first();
        $appointment = Appointment::with('user')->find($appointment_id);
        $notification_template = NotificationTemplate::where('title', 'status change')->first();

        $placeholders = [
            '{{user_name}}' => $appointment->user->name,
            '{{appointment_id}}' => $appointment->appointment_id,
            '{{date}}' => Carbon::now(env('timezone'))->format('Y-m-d'),
            '{{status}}' => $status,
            '{{app_name}}' => $setting->business_name,
        ];

        $msg1 = $notification_template->msg_content;
        $mail1 = $notification_template->mail_content;

        $placeholder_keys = array_keys($placeholders);
        $placeholder_values = array_values($placeholders);
        $msg1 = str_ireplace($placeholder_keys, $placeholder_values, $msg1);
        $mail1 = str_ireplace($placeholder_keys, $placeholder_values, $mail1);

        if ($setting->patient_mail == 1) {
            try {
                $config = [
                    'driver' => $setting->mail_mailer,
                    'host' => $setting->mail_host,
                    'port' => $setting->mail_port,
                    'from' => ['address' => $setting->mail_from_address, 'name' => $setting->mail_from_name],
                    'encryption' => $setting->mail_encryption,
                    'username' => $setting->mail_username,
                    'password' => $setting->mail_password,
                ];
                Config::set('mail', $config);
                Mail::to($appointment->user->email)->send(new SendMail($mail1, $notification_template->subject));
            } catch (\Exception $e) {
                info($e);
            }
        }

        if ($setting->patient_notification == 1) {
            try {
                Config::set('onesignal.app_id', $setting->patient_app_id);
                Config::set('onesignal.rest_api_key', $setting->patient_api_key);
                Config::set('onesignal.user_auth_key', $setting->patient_auth_key);
                OneSignal::sendNotificationToUser(
                    $msg1,
                    $appointment->user->device_token,
                    $url = null,
                    $data = null,
                    $buttons = null,
                    $schedule = null,
                    $setting->business_name
                );
            } catch (\Exception $e) {
                info($e->getMessage());
            }
        }

        $user_notification = [];
        $user_notification['user_id'] = auth()->user()->id;
        $user_notification['doctor_id'] = $appointment->doctor_id;
        $user_notification['user_type'] = 'user';
        $user_notification['title'] = 'create appointment';
        $user_notification['message'] = $msg1;
        Notification::create($user_notification);

        return true;
    }

    public function appointment()
    {
        abort_if(Gate::denies('appointment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        (new CustomController)->cancel_max_order();
        $currency = Setting::first()->currency_symbol;

        $is_zoom_enabled = false;
        $is_zoom_logged_in = false;
        $url = '';

        if (! auth()->user()->hasRole('doctor')) {
            $appointments = Appointment::with(['doctor', 'address'])->orderBy('id', 'DESC')->get();
        } else {
            $doctor = Doctor::where('user_id', auth()->user()->id)->first();
            $appointments = Appointment::with(['doctor', 'address', 'hospital'])->where('doctor_id', $doctor->id)->orderBy('id', 'DESC')->get();
            foreach ($appointments as $appointment) {
                if (Prescription::where('appointment_id', $appointment->id)->first()) {
                    $appointment->prescription = '1';
                    $appointment->preData = Prescription::where('appointment_id', $appointment->id)->first();
                } else {
                    $appointment->prescription = '0';
                }
            }

            // / ZOOM SETTINGS
            $zoom_settings = Setting::select('zoom_switch', 'zoom_client_id', 'zoom_client_secret', 'zoom_redirect_url')->first();
            if ($zoom_settings->zoom_switch == 1) {
                $is_zoom_enabled = true;
                $is_zoom_logged_in = auth()->user()->zoomOAuth->is_access_token_valid;
                $url = (new \App\Http\Controllers\Doctor\ZoomOAuthController)->createBaseLoginURL();
            }
        }

        return view('superAdmin.appointment.appointment', compact('appointments', 'currency', 'is_zoom_enabled', 'is_zoom_logged_in', 'url'));
    }

    public function show_appointment($appointment_id)
    {
        (new CustomController)->cancel_max_order();
        $currency = Setting::first()->currency_symbol;
        $appointment = Appointment::with(['doctor', 'address', 'hospital'])->find($appointment_id);

        return response(['success' => true, 'data' => $appointment, 'currency' => $currency]);
    }

    public function prescription($appointment_id)
    {
        (new CustomController)->cancel_max_order();
        $appointment = Appointment::with(['doctor', 'user'])->find($appointment_id);
        $doctor = Doctor::with(['expertise', 'treatment', 'category'])->find($appointment->doctor_id);
        $medicines = Medicine::whereStatus('1')->get();

        return view('superAdmin.doctor.prescription', compact('appointment', 'doctor', 'medicines'));
    }

    public function all_medicine()
    {
        $medicines = Medicine::whereStatus('1')->get();

        return response(['success' => true, 'data' => $medicines]);
    }

    public function addPrescription(Request $request)
    {
        $data = $request->all();
        $medicine = [];
        for ($i = 0; $i < count($data['medicines']); $i++) {
            $temp['medicine'] = $data['medicines'][$i];
            $temp['days'] = $data['day'][$i];
            $temp['morning'] = isset($data['morning'.$i]) ? 1 : 0;
            $temp['afternoon'] = isset($data['afternoon'.$i]) ? 1 : 0;
            $temp['night'] = isset($data['night'.$i]) ? 1 : 0;
            array_push($medicine, $temp);
        }
        $pre['medicines'] = json_encode($medicine);
        $pre['appointment_id'] = $data['appointment_id'];
        $pre['doctor_id'] = Doctor::where('user_id', auth()->user()->id)->first()->id;
        $pre['user_id'] = $data['user_id'];
        $pres = Prescription::create($pre);
        $prescription = Prescription::with(['doctor', 'user'])->find($pres->id);
        $prescription->doctorUser = User::find($prescription->doctor['user_id']);

        $medicineName = $pres->medicines;
        $pdf = PDF::loadView('temp', compact('medicineName'));
        $path = public_path().'/prescription/upload';
        $fileName = uniqid().'.'.'pdf';
        $pdf->save($path.'/'.$fileName);
        $pres->pdf = $fileName;
        $pres->save();

        return redirect('/appointment');
    }

    public function changeTimeslot(Request $request)
    {
        $doctor = Doctor::where('user_id', auth()->user()->id)->first();
        $timeslots = (new CustomController)->timeSlot($doctor->id, $request->date);

        return response(['success' => true, 'data' => $timeslots]);
    }

    public function createAppointment($id)
    {
        $patient = User::where('id', $id)->first();
        $doctor = Doctor::with(['category', 'expertise'])->where('user_id', auth()->user()->id)->first();
        $hosp = explode(',', $doctor->hospital_id);
        $hospitals = Hospital::whereIn('id', $hosp)->get();
        $patient_addressess = UserAddress::where('user_id', $id)->get();
        $date = Carbon::now(env('timezone'))->format('Y-m-d');
        $timeslots = (new CustomController)->timeSlot($doctor->id, $date);
        $setting = Setting::first();

        return view('superAdmin.appointment.create_appointment', compact('setting', 'patient', 'doctor', 'hospitals', 'date', 'patient_addressess', 'timeslots'));
    }

    public function storeAppointment(Request $request, $id)
    {
        $data = $request->all();
        $request->validate([
            'illness_information' => 'bail|required',
            'age' => 'bail|required|numeric',
            'patient_address' => 'bail|required',
            'drug_effect' => 'bail|required',
            'note' => 'bail|required',
            'date' => 'bail|required',
            'time' => 'bail|required',
            'hospital_id' => 'bail|required',

        ]);
        $patient = User::where('id', $id)->first();
        $doctor = Doctor::where('user_id', auth()->user()->id)->first();
        $data['appointment_id'] = '#'.rand(100000, 999999);
        $data['appointment_status'] = 'pending';
        $data['patient_name'] = $patient->name;
        $data['phone_no'] = $patient->phone;
        $data['user_id'] = $id;
        $data['doctor_id'] = $doctor->id;
        $data['appointment_for'] = 'my_self';
        $data['payment_status'] = 0;
        $data['is_from'] = 1;
        if ($request->hasFile('report_image')) {
            $report = [];
            for ($i = 0; $i < count($data['report_image']); $i++) {
                // return $request->report_image[$i];
                array_push($report, (new CustomController)->imageUpload($request->report_image[$i]));
            }
            $data['report_image'] = json_encode($report);
        }
        // dd($data);

        if ($doctor->based_on == 'commission') {
            $comm = $doctor->appointment_fees * $doctor->commission_amount;
            $data['admin_commission'] = intval($comm / 100);
            $data['doctor_commission'] = intval($doctor->appointment_fees - $data['admin_commission']);
        } else {
            DoctorSubscription::where('doctor_id', $doctor->id)->latest()->first()->increment('booked_appointment');
        }
        $data['amount'] = $doctor->appointment_fees;
        $data['payment_type'] = 'COD';
        $data = array_filter($data, function ($a) {
            return $a !== '';
        });
        $appointment = Appointment::create($data);
        (new CustomController)->scheduledReminderNotification($appointment->id);

        return redirect('appointment')->with('status', __('Appointment Add successfully...!!'));
    }

    public function editAppointment($id)
    {
        $appointment = Appointment::where('id', $id)->where('doctor_id', Doctor::where('user_id', auth()->user()->id)->first()->id)->where('is_from', 1)->first();
        if (! $appointment) {
            return redirect('appointment')->with('status', __('Unauthorized!'));
        }
        $patient = User::where('id', $appointment->user_id)->first();
        $doctor = Doctor::where('id', $appointment->doctor_id)->first();
        $hosp = explode(',', $doctor->hospital_id);
        $hospitals = Hospital::whereIn('id', $hosp)->get();
        $patient_addressess = UserAddress::where('user_id', $appointment->user_id)->get();
        $date = $appointment->date;
        $timeslots = (new CustomController)->timeSlot($doctor->id, $date);
        $setting = Setting::first();

        return view('superAdmin.appointment.edit_appointment', compact('setting', 'appointment', 'hospitals', 'patient_addressess', 'date', 'timeslots', 'patient'));
    }

    public function updateAppointment(Request $request, $id)
    {
        $data = $request->all();
        $request->validate([
            'illness_information' => 'bail|required',
            'age' => 'bail|required|numeric',
            'patient_address' => 'bail|required',
            'drug_effect' => 'bail|required',
            'note' => 'bail|required',
            'date' => 'bail|required',
            'time' => 'bail|required',
            'hospital_id' => 'bail|required',
        ]);
        $appointment = Appointment::find($id);
        if ($appointment->date != $request->date) {
            $request->validate([
                'date' => 'bail|required|after:yesterday',
            ],
                [
                    'date.after' => 'Date must be future date.',
                ]
            );
        }
        $patient = User::where('id', $appointment->user_id)->first();
        $doctor = Doctor::where('id', $appointment->doctor_id)->first();
        $data['appointment_id'] = $appointment->appointment_id;
        $data['appointment_status'] = $appointment->appointment_status;
        $data['patient_name'] = $appointment->patient_name;
        $data['phone_no'] = $appointment->phone_no;
        $data['user_id'] = $patient->id;
        $data['doctor_id'] = $doctor->id;
        $data['appointment_for'] = $appointment->appointment_for;
        $data['payment_status'] = $appointment->payment_status;
        $data['is_from'] = 1;
        $report = [];
        for ($i = 0; $i < 3; $i++) {
            $report_img = json_decode(DB::table('appointment')->where('id', $appointment->id)->value('report_image'));
            if ($data['type'.$i] === 'new') {
                if ($i == $data['change_iteration'.$i] && $data['change_iteration'.$i] != null) {
                    if (isset($appointment->report_image[$i])) {
                        (new CustomController)->deleteFile($report_img[$i]);
                    }
                    array_push($report, (new CustomController)->imageUpload($request->file('report_image')[$i]));
                }
            }
            if ($data['type'.$i] === 'old') {
                array_push($report, $report_img[$i]);

            }
        }
        if (count($report) > 0) {
            $data['report_image'] = json_encode($report);
        }

        $data['amount'] = $doctor->appointment_fees;
        $data['payment_type'] = $appointment->payment_type;
        $data = array_filter($data, function ($a) {
            return $a !== '';
        });
        $appointment->update($data);

        return redirect('appointment')->with('status', __('Appointment Update successfully...!!'));
    }

    public function deleteAppointment($id)
    {
        $appointment = Appointment::where('id', $id)->where('doctor_id', Doctor::where('user_id', auth()->user()->id)->first()->id)->where('is_from', 1)->first();
        if (! $appointment) {
            return redirect('appointment')->with('status', __('Unauthorized!'));
        }

        if (isset($appointment->image)) {
            for ($i = 0; $i < count($appointment['report_image']); $i++) {
                (new CustomController)->deleteFile($appointment->report_image[$i]);
            }
        }
        (new CustomController)->cancelScheduledNotification($appointment->scheduled_notification_id_patient, $appointment->scheduled_notification_id_doctor);
        $appointment->delete();
        if (Prescription::where('appointment_id', $id)->exists()) {
            $pdfName = Prescription::where('appointment_id', $id)->first()->pdf;
            Prescription::where('appointment_id', $id)->delete();
            (new CustomController)->deletePrescription($pdfName);
        }

        return redirect('appointment')->with('status', __('Appointment Delete successfully...!!'));
    }

    public function addAddr(Request $request)
    {
        $request->validate([
            'address' => 'bail|required',
            'lang' => 'bail|required',
            'lat' => 'bail|required',
        ]);
        $userAddress = UserAddress::create($request->all());

        return response(['success' => true, 'data' => $userAddress]);
    }
}
