<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SuperAdmin\CustomController;
use App\Models\Appointment;
use App\Models\Category;
use App\Models\Doctor;
use App\Models\DoctorSubscription;
use App\Models\Expertise;
use App\Models\Hospital;
use App\Models\Medicine;
use App\Models\Notification;
use App\Models\Prescription;
use App\Models\Review;
use App\Models\Setting;
use App\Models\Settle;
use App\Models\Subscription;
use App\Models\Treatments;
use App\Models\User;
use App\Models\WorkingHour;
use Berkayk\OneSignal\OneSignalClient;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use OneSignal;

include 'RtcTokenBuilder.php';

class DoctorApiController extends Controller
{
    public function apiDoctorLogin(Request $request)
    {
        $request->validate([
            'email' => 'bail|required|email',
            'password' => 'bail|required|min:6',
        ]);

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $userDoctor = Auth::user()->load('roles');
            if ($userDoctor->hasRole('doctor')) {
                if ($userDoctor->verify == 1) {
                    $doctor = Doctor::where('user_id', auth()->user()->id)->first();
                    if (isset($request->device_token)) {
                        $userDoctor->device_token = $request->device_token;
                        $userDoctor->save();
                    }
                    $userDoctor['is_filled'] = $doctor->is_filled;
                    if ($doctor->status == 1) {
                        if ($doctor->based_on == 'subscription') {
                            $subscription = DoctorSubscription::where([['doctor_id', $doctor->id], ['status', 1]])->first();
                            if ($subscription) {
                                $cDate = Carbon::parse($doctor['start_time'])->format('Y-m-d');
                                if ($subscription->end_date > $cDate) {
                                    // subscription active
                                    $userDoctor['subscription_status'] = 1;
                                    $doctor->update(['subscription_status' => 1]);
                                    $userDoctor['token'] = $userDoctor->createToken('doctro')->accessToken;
                                    $userDoctor['image'] = $doctor->fullImage;
                                    $userDoctor->makeHidden(['email_verified_at', 'dob', 'gender', 'status', 'doctor_id']);
                                    $userDoctor['device_token'] = $userDoctor['device_token'] == null ? '' : $userDoctor['device_token'];
                                    $userDoctor['language'] = $userDoctor['language'] == null ? '' : $userDoctor['language'];
                                    $userDoctor['channel_name'] = $userDoctor['channel_name'] == null ? '' : $userDoctor['channel_name'];
                                    $userDoctor['agora_token'] = $userDoctor['agora_token'] == null ? '' : $userDoctor['agora_token'];

                                    return response(['success' => true, 'data' => $userDoctor, 'msg' => 'Doctor Login successfully']);
                                } else {
                                    // subscription expire
                                    $userDoctor['subscription_status'] = 0;
                                    $doctor->update(['subscription_status' => 0]);
                                    $userDoctor['token'] = $userDoctor->createToken('doctro')->accessToken;
                                    $userDoctor['image'] = $doctor->fullImage;
                                    $userDoctor->makeHidden(['email_verified_at', 'dob', 'gender', 'status', 'doctor_id']);
                                    $userDoctor['device_token'] = $userDoctor['device_token'] == null ? '' : $userDoctor['device_token'];
                                    $userDoctor['language'] = $userDoctor['language'] == null ? '' : $userDoctor['language'];
                                    $userDoctor['channel_name'] = $userDoctor['channel_name'] == null ? '' : $userDoctor['channel_name'];
                                    $userDoctor['agora_token'] = $userDoctor['agora_token'] == null ? '' : $userDoctor['agora_token'];

                                    return response(['success' => true, 'data' => $userDoctor, 'msg' => 'Your subscription plan is expires']);
                                }
                            } else {
                                $userDoctor['subscription_status'] = 0;
                                $doctor->update(['subscription_status' => 0]);
                                $userDoctor['token'] = $userDoctor->createToken('doctro')->accessToken;
                                $userDoctor['image'] = $doctor->fullImage;
                                $userDoctor->makeHidden(['email_verified_at', 'dob', 'gender', 'status', 'doctor_id']);
                                $userDoctor['device_token'] = $userDoctor['device_token'] == null ? '' : $userDoctor['device_token'];
                                $userDoctor['language'] = $userDoctor['language'] == null ? '' : $userDoctor['language'];
                                $userDoctor['channel_name'] = $userDoctor['channel_name'] == null ? '' : $userDoctor['channel_name'];
                                $userDoctor['agora_token'] = $userDoctor['agora_token'] == null ? '' : $userDoctor['agora_token'];

                                return response(['success' => true, 'data' => $userDoctor, 'msg' => 'Your subscription plan is expires']);
                            }
                        } else {
                            $userDoctor['token'] = $userDoctor->createToken('doctro')->accessToken;
                            $userDoctor['image'] = $doctor->fullImage;
                            $userDoctor->makeHidden(['email_verified_at', 'dob', 'gender', 'status', 'doctor_id']);
                            $userDoctor['device_token'] = $userDoctor['device_token'] == null ? '' : $userDoctor['device_token'];
                            $userDoctor['language'] = $userDoctor['language'] == null ? '' : $userDoctor['language'];
                            $userDoctor['channel_name'] = $userDoctor['channel_name'] == null ? '' : $userDoctor['channel_name'];
                            $userDoctor['agora_token'] = $userDoctor['agora_token'] == null ? '' : $userDoctor['agora_token'];

                            return response(['success' => true, 'data' => $userDoctor, 'msg' => 'Doctor Login successfully']);
                        }
                    } else {
                        return response(['success' => false, 'msg' => 'You are blocked please contact to admin.']);
                    }
                } else {
                    (new CustomController)->sendOtp($userDoctor);
                    $userDoctor->makeHidden(['email_verified_at', 'dob', 'gender', 'status', 'doctor_id']);

                    return response(['success' => false, 'data' => $userDoctor, 'msg' => 'otp send into your account please verify']);
                }
            } else {
                return response(['success' => false, 'msg' => 'Only doctor can login']);
            }
        } else {
            return response(['success' => false, 'msg' => 'Invalid Email or Password!.']);
        }
    }

    // Logout
    public function apiLogout(Request $request)
    {
        $user = Auth::user();
        $user->update(['device_token' => null]);
        $all_devices = request()->query('all_devices', '0');
        if ($all_devices == 1) {
            $user->tokens()->delete();
        } else {
            $user->token()->delete();
        }

        return response()->json(['success' => true, 'msg' => 'Successfully logged out']);
    }

    public function apiDoctorRegister(Request $request)
    {
        $request->validate([
            'name' => 'bail|required|unique:doctor',
            'email' => 'bail|required|email|unique:users',
            'dob' => 'bail|required|date_format:Y-m-d',
            'gender' => 'bail|required',
            'phone' => 'bail|required|numeric',
            'password' => 'bail|required|min:6',
            'phone_code' => 'bail|required',
        ]);
        $data = $request->all();
        $setting = Setting::first();
        $verificationRequires = $setting->verification;
        $isVerified = $verificationRequires == 1 ? 0 : 1;
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($request->password),
            'verify' => $isVerified,
            'phone' => $data['phone'],
            'phone_code' => $data['phone_code'],
            'image' => 'defaultUser.png',
            'status' => 1,
            'dob' => $data['dob'],
            'gender' => $data['gender'],
        ]);
        $user->assignRole('doctor');
        if (isset($request->device_token)) {
            $user->device_token = $request->device_token;
            $user->save();
        }
        $data['user_id'] = $user->id;
        $data['image'] = 'defaultUser.png';
        $data['based_on'] = $setting->default_base_on;
        if ($data['based_on'] == 'commission') {
            $data['commission_amount'] = $setting->default_commission;
        }
        $data['since'] = Carbon::now(env('timezone'))->format('Y-m-d , h:i A');
        $data['status'] = 1;
        $data['name'] = $user->name;
        $data['dob'] = $request->dob;
        $data['gender'] = $request->gender;
        $data['start_time'] = '08:00 am';
        $data['end_time'] = '08:00 pm';
        $data['timeslot'] = 15;
        $data['is_filled'] = 0;
        $data['subscription_status'] = 1;
        $doctor = Doctor::create($data);
        $userDoctor = User::find($doctor->user_id);
        if ($doctor->based_on == 'subscription') {
            $subscription = Subscription::where('name', 'free')->first();
            if ($subscription) {
                $doctor_subscription['doctor_id'] = $doctor->id;
                $doctor_subscription['subscription_id'] = $subscription->id;
                $doctor_subscription['duration'] = 1;
                $doctor_subscription['start_date'] = Carbon::now(env('timezone'))->format('Y-m-d');
                $doctor_subscription['end_date'] = Carbon::now(env('timezone'))->addMonths(1)->format('Y-m-d');
                $doctor_subscription['status'] = 1;
                $doctor_subscription['payment_status'] = 1;
                DoctorSubscription::create($doctor_subscription);
            }
        }
        $data['status'] = 1;
        $start_time = strtolower('08:00 am');
        $end_time = strtolower('08:00 pm');
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        for ($i = 0; $i < count($days); $i++) {
            $master = [];
            $temp2['start_time'] = $start_time;
            $temp2['end_time'] = $end_time;
            array_push($master, $temp2);
            $work_time['doctor_id'] = $doctor->id;
            $work_time['period_list'] = json_encode($master);
            $work_time['day_index'] = $days[$i];
            $work_time['status'] = 1;
            WorkingHour::create($work_time);
        }
        if ($user->verify == 1) {
            if (Auth::attempt(['email' => $user['email'], 'password' => $request->password])) {
                $userDoctor['token'] = $user->createToken('doctro')->accessToken;
                $userDoctor['is_filled'] = $doctor->is_filled;

                return response(['success' => true, 'data' => $userDoctor, 'msg' => 'Register Successfully']);
            }
        } else {
            info('calling otp');
            (new CustomController)->sendOtp($user);
            $user['is_filled'] = $doctor->is_filled;

            return response(['success' => false, 'data' => $user, 'msg' => 'otp send into your account please verify']);
        }
    }

    public function apiDoctorAppointment()
    {

        $doctor = Doctor::where('user_id', auth()->user()->id)->first();

        // (new CustomController)->cancel_max_order();
        // $appointments = Appointment::with(['user:id,image','hospital:id,name,address'])->where('doctor_id',$doctor->id)->whereDate('created_at', Carbon::today())->get(['id','hospital_id','time','date','age','patient_name','amount','patient_address','user_id']);
        // foreach ($appointments as $appointment)
        // {
        //      if ($appointment->hospital == null) {
        //         unset($appointment['hospital']);
        //         $appointment['hospital'] = (object)[];
        //         $appointment['hospital_id'] = 0;
        //     }
        // }

        $appointments['today'] = Appointment::with(['user:id,image', 'hospital:id,name,address'])->where('doctor_id', $doctor->id)->whereDate('date', Carbon::today())->orderBy('time', 'ASC')->get(['id', 'hospital_id', 'time', 'date', 'age', 'patient_name', 'amount', 'patient_address', 'user_id']);
        foreach ($appointments['today'] as $appointment) {
            if ($appointment->hospital == null) {
                unset($appointment['hospital']);
                $appointment['hospital'] = (object) [];
                $appointment['hospital_id'] = 0;
            }
        }

        $appointments['tomorrow'] = Appointment::with(['user:id,image', 'hospital:id,name,address'])->where('doctor_id', $doctor->id)->whereDate('date', Carbon::tomorrow())->orderBy('time', 'ASC')->get(['id', 'hospital_id', 'time', 'date', 'age', 'patient_name', 'amount', 'patient_address', 'user_id']);
        foreach ($appointments['tomorrow'] as $appointment) {
            if ($appointment->hospital == null) {
                unset($appointment['hospital']);
                $appointment['hospital'] = (object) [];
                $appointment['hospital_id'] = 0;
            }
        }
        $appointments['upcoming'] = Appointment::with(['user:id,image', 'hospital:id,name,address'])->where('doctor_id', $doctor->id)->whereDate('date', '>=', new \DateTime('tomorrow + 1day'))->orderBy('time', 'ASC')->get(['id', 'hospital_id', 'time', 'date', 'age', 'patient_name', 'amount', 'patient_address', 'user_id']);
        foreach ($appointments['upcoming'] as $appointment) {
            if ($appointment->hospital == null) {
                unset($appointment['hospital']);
                $appointment['hospital'] = (object) [];
                $appointment['hospital_id'] = 0;
            }
        }

        return response(['success' => true, 'data' => $appointments, 'msg' => 'Doctor Today appointment']);
    }

    public function apiMedicines()
    {
        $medicines = Medicine::whereStatus(1)->get(['id', 'name'])->makeHidden(['fullImage']);

        return response(['success' => true, 'data' => $medicines, 'msg' => 'Medicines']);
    }

    public function apiSingleAppointment($id)
    {
        (new CustomController)->cancel_max_order();
        $appointment = Appointment::with('user:id,image')->where('id', $id)->first()->makeHidden(['admin_commission', 'cancel_reason', 'cancel_by', 'discount_id', 'discount_price', 'payment_token', 'created_at', 'updated_at', 'doctor_commission']);
        if ($appointment['report_image'] == null) {
            $appointment['report_image'] = '';
        }
        $appointment['pdf'] = '';
        if (Prescription::where('appointment_id', $id)->exists()) {
            $pdf = Prescription::where('appointment_id', $id)->first()->pdf;
            $appointment['pdf'] = url('prescription/upload').'/'.$pdf;
        }

        return response(['success' => true, 'data' => $appointment, 'msg' => 'Doctor Today appointment']);
    }

    public function apiAddPrescription(Request $request)
    {
        $request->validate([
            'appointment_id' => 'bail|required',
            'medicines' => 'bail|required',
            'user_id' => 'bail|required',
            // 'pdf' => 'bail|required'
        ]);
        $data = $request->all();
        $medicine = [];
        foreach (json_decode($data['medicines']) as $tempMedicine) {
            $temp['medicine'] = $tempMedicine->medicine;
            $temp['days'] = $tempMedicine->days;
            $temp['morning'] = $tempMedicine->morning;
            $temp['afternoon'] = $tempMedicine->afternoon;
            $temp['night'] = $tempMedicine->night;
            array_push($medicine, $temp);
        }
        $pre['medicines'] = json_encode($medicine);
        $pre['appointment_id'] = $data['appointment_id'];
        $pre['doctor_id'] = Doctor::where('user_id', auth()->user()->id)->first()->id;
        $pre['user_id'] = $data['user_id'];
        if (isset($data['pdf'])) {
            $test = explode('.', $data['pdf']);
            $ext = end($test);
            $name = uniqid().'.'.'pdf';
            $location = public_path().'/prescription/upload';
            $data['pdf']->move($location, $name);
            $pre['pdf'] = $name;
        }
        $pres = Prescription::create($pre);
        $pdf = url('prescription/upload/'.$pres->pdf);

        return response(['success' => true, 'data' => $pdf, 'msg' => 'Prescription Created']);
    }

    public function apiWorkingHours()
    {
        $doctor = Doctor::where('user_id', auth()->user()->id)->first();
        $timing = WorkingHour::where('doctor_id', $doctor->id)->get()->makeHidden(['created_at', 'updated_at']);

        return response(['success' => true, 'data' => $timing, 'msg' => 'Doctor Timming']);
    }

    public function apiUpdateWorkingHours(Request $request)
    {
        $request->validate([
            'id' => 'bail|required',
            'period_list' => 'bail|required',
            'status' => 'bail|required',
        ]);
        $data = $request->all();
        $working = WorkingHour::find($data['id']);
        $working->update($data);

        return response(['success' => true, 'msg' => 'Timming updated']);
    }

    public function apiLoginDoctor(Request $request)
    {
        $doctor = Doctor::where('user_id', auth()->user()->id)->first()->makeHidden(['rate', 'review']);
        $doctor->email = User::find($doctor->user_id)->email;
        $doctor->phone = User::find($doctor->user_id)->phone;
        $token = User::find($doctor->user_id)->agora_token;
        $cn = User::find($doctor->user_id)->channel_name;
        $doctor->agora_token = $token == null ? '' : $token;
        $doctor->channel_name = $cn == null ? '' : $cn;

        return response(['success' => true, 'data' => $doctor, 'msg' => 'login doctor details']);
    }

    public function apiUpdateDoctor(Request $request)
    {
        $id = Doctor::where('user_id', auth()->user()->id)->first();
        $request->validate([
            'name' => 'bail|required',
            'treatment_id' => 'bail|required',
            'category_id' => 'bail|required',
            'dob' => 'bail|required|date_format:Y-m-d',
            'gender' => 'bail|required',
            'expertise_id' => 'bail|required',
            'timeslot' => 'bail|required',
            'start_time' => 'bail|required|date_format:h:i a',
            'end_time' => 'bail|required|date_format:h:i a|after:start_time',
            'hospital_id' => 'bail|required',
            'desc' => 'required',
            'appointment_fees' => 'required|numeric',
            'experience' => 'bail|required|numeric',
            'education' => 'bail|required',
            'certificate' => 'bail|required',
        ]);
        $data = $request->all();
        $data['is_filled'] = 1;
        $id->update($data);

        return response(['success' => true, 'msg' => 'successfully Update']);
    }

    public function apiDoctorReview()
    {
        $doctor = Doctor::where('user_id', auth()->user()->id)->first();
        $reviews = Review::with('user:id,name,image')->where('doctor_id', $doctor->id)->get()->makeHidden(['updated_at']);

        return response(['success' => true, 'data' => $reviews, 'msg' => 'Doctor Reviews']);
    }

    public function apiTreatment()
    {
        $treatment = Treatments::whereStatus(1)->get(['id', 'name']);

        return response(['success' => true, 'data' => $treatment, 'msg' => 'Treatments']);
    }

    public function apiCategory($treatment_id)
    {
        $categories = Category::where([['treatment_id', $treatment_id], ['status', 1]])->get(['id', 'name']);

        return response(['success' => true, 'data' => $categories, 'msg' => 'Categories']);
    }

    public function apiExpertise($category_id)
    {
        $expertises = Expertise::where([['category_id', $category_id], ['status', 1]])->get(['id', 'name']);

        return response(['success' => true, 'data' => $expertises, 'msg' => 'Expertises']);
    }

    public function apiHospital()
    {
        $hospitals = Hospital::where('status', 1)->get(['id', 'name']);

        return response(['success' => true, 'data' => $hospitals, 'msg' => 'hospital']);
    }

    public function apiStatusChange(Request $request)
    {
        (new CustomController)->cancel_max_order();
        $request->validate([
            'id' => 'required',
            'status' => 'required|in:approve,cancel,complete',
        ]);
        $appointment = Appointment::find($request->id);
        $appointment->update(['appointment_status' => $request->status, 'payment_status' => 1]);
        $user = User::find($appointment->user_id);
        $doctor = Doctor::find($appointment->doctor_id);
        if ($request->status == 'completed') {
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
        }
        (new CustomController)->statusChangeNotification($user, $appointment, $request->status);
        if ($request->status == 'cancel') {
            (new CustomController)->cancelScheduledNotification($appointment->scheduled_notification_id_patient, $appointment->scheduled_notification_id_doctor);
        }

        return response(['success' => true, 'msg' => 'appointment status change']);
    }

    public function apiAppointmentHistory()
    {
        (new CustomController)->cancel_max_order();
        $doctor = Doctor::with('treatment:id,name')->where('user_id', auth()->user()->id)->first();
        $future = [];
        $past = [];
        $appointments = Appointment::with(['user:id,image', 'hospital:id,name,address'])->where('doctor_id', $doctor->id)->orderBy('id', 'DESC')->get(['id', 'date', 'time', 'user_id', 'hospital_id', 'patient_address', 'patient_name', 'appointment_status']);
        foreach ($appointments as $appointment) {
            if ($appointment->hospital == null) {
                unset($appointment['hospital']);
                $appointment['hospital'] = (object) [];
                $appointment['hospital_id'] = 0;
            }
            $appointment->treatment = $doctor->treatment['name'];
            $appointment->doctor_name = $doctor->name;
            $appointment->timming = new DateTime($appointment['date'].$appointment['time']);
            if ($appointment->timming >= Carbon::now(env('timezone')) && $appointment->appointment_status != 'completed' && $appointment->appointment_status != 'canceled') {
                unset($appointment['timming']);
                array_push($future, $appointment);
            } else {
                unset($appointment['timming']);
                array_push($past, $appointment);
            }
        }
        $appointment_history['upcoming_appointment'] = $future;
        $appointment_history['past_appointment'] = $past;

        return response(['success' => true, 'data' => $appointment_history]);
    }

    public function apiPayment(Request $request)
    {
        $doctor = Doctor::where('user_id', auth()->user()->id)->first();
        $payment = Appointment::with('user:id,name')->where('doctor_id', $doctor->id);
        if ($request->month && $request->year) {
            $payment = $payment->whereMonth('created_at', $request->month)->whereYear('created_at', $request->year);
        } else {
            $payment = $payment->whereMonth('created_at', date('m'));
        }
        $payment = $payment->get(['id', 'user_id', 'amount']);

        return response(['success' => true, 'data' => $payment]);
    }

    public function apiSubscription()
    {
        $doctor = Doctor::where('user_id', auth()->user()->id)->first();
        $subscriptions = Subscription::orderBy('id', 'DESC')->get()->makeHidden(['created_at', 'updated_at']);
        $purchase_subscription = DoctorSubscription::where([['doctor_id', $doctor->id], ['status', 1]])->first();

        return response(['success' => true, 'data' => $subscriptions, 'purchase_subacription' => $purchase_subscription]);
    }

    public function apiFinanceDetails()
    {
        $doctor = Doctor::where('user_id', auth()->user()->id)->first();
        $finance_details = '';
        if ($doctor->based_on == 'subscription') {
            $finance_details = DoctorSubscription::with('subscription:id,name')->where('doctor_id', $doctor->id)->orderBy('id', 'DESC')->get()->makeHidden('');
            foreach ($finance_details as $value) {
                $value['doctor_name'] = $doctor->name;
            }
        }
        if ($doctor->based_on == 'commission') {
            $past = Carbon::now(env('timezone'))->subDays(35);
            $now = Carbon::today();
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
            $finance_details = $settels;
        }

        return response(['success' => true, 'data' => $finance_details]);
    }

    public function apiNotification()
    {
        $doctor = Doctor::where('user_id', auth()->user()->id)->first();
        $data = Notification::with('user:id,name,image')->where([['doctor_id', $doctor->id], ['user_type', 'doctor']])->get();

        return response(['success' => true, 'data' => $data]);
    }

    public function apiPurchaseSubscription(Request $request)
    {
        $request->validate([
            'subscription_id' => 'bail|required',
            'payment_status' => 'bail|required',
            'payment_type' => 'bail|required',
            'duration' => 'bail|required',
        ]);
        $data = $request->all();
        $doctor = Doctor::where('user_id', auth()->user()->id)->first();
        DoctorSubscription::where([['status', 1], ['doctor_id', $doctor->id]])->update(['status' => 0]);
        $data['doctor_id'] = $doctor->id;
        $data['start_date'] = Carbon::now(env('timezone'))->format('Y-m-d');
        $data['end_date'] = Carbon::now(env('timezone'))->addMonths($data['duration'])->format('Y-m-d');
        $data['status'] = 1;
        $subscription = DoctorSubscription::create($data);
        if ($subscription->payment_status == 1) {
            $doctor->subscription_status = 1;
            $doctor->save();
        } else {
            $doctor->subscription_status = 0;
            $doctor->save();
        }
        if ($subscription->payment_type == 'FLUTTERWAVE') {
            return response(['success' => true, 'url' => url('subscription_flutter/'.$subscription->id)]);
        }

        return response(['success' => true]);
    }

    public function apiUpdateImage(Request $request)
    {
        $request->validate([
            'image' => 'required',
        ]);
        $doctor = Doctor::where('user_id', auth()->user()->id)->first();
        if (isset($request->image)) {
            (new CustomController)->deleteFile($doctor->image);
            $img = $request->image;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data1 = base64_decode($img);
            $Iname = uniqid();
            $file = public_path('/images/upload/').$Iname.'.png';
            $success = file_put_contents($file, $data1);
            $data['image'] = $Iname.'.png';
        }
        $doctor->update($data);

        return response(['success' => true, 'data' => $doctor->fullImage]);
    }

    public function apiCancelAppointment()
    {
        $doctor = Doctor::with('treatment:id,name')->where('user_id', auth()->user()->id)->first();
        $cancel_appointment = Appointment::with('user:id,image')->where([['doctor_id', $doctor->id], ['appointment_status', 'CANCELED']])->get(['id', 'date', 'time', 'user_id', 'patient_address', 'patient_name', 'age', 'amount']);

        return response(['success' => true, 'data' => $cancel_appointment]);
    }

    public function apiDoctorChangePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'bail|required|min:6',
            'password' => 'bail|required|min:6',
            'password_confirmation' => 'bail|required|min:6',
        ]);
        $data = $request->all();
        $id = auth()->user();
        if (Hash::check($data['old_password'], $id->password) == true) {
            if ($data['password'] == $data['password_confirmation']) {
                $id->password = Hash::make($data['password']);
                $id->save();

                return response(['success' => true, 'data' => 'Password Update Successfully...!!']);
            } else {
                return response(['success' => false, 'data' => 'password and confirm password does not match']);
            }
        } else {
            return response(['success' => false, 'data' => 'Old password does not match.']);
        }
    }

    public function apiDoctorGenerateToken(Request $request)
    {
        $request->validate([
            'to_id' => 'bail|required',
        ]);
        $cn = $request->to_id.uniqid();
        $settings = Setting::select('agora_app_id', 'agora_app_certificate')->first();
        $appID = $settings->agora_app_id;
        $appCertificate = $settings->agora_app_certificate;
        if ($appID != null && $appCertificate != null) {
            $channelName = $cn;
            $uid = 0;
            $role = \RtcTokenBuilder::RolePublisher;
            $expireTimeInSeconds = 180;
            $currentTimestamp = (new DateTime('now', new DateTimeZone(env('timezone'))))->getTimestamp();
            $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;
            // Find the Patient User Model for Call Receiver
            $patient_user = User::find($request->to_id);

            $token = \RtcTokenBuilder::buildTokenWithUid($appID, $appCertificate, $channelName, $uid, $role, $privilegeExpiredTs);

            // Find the User Model for Patient
            User::whereIn('id', [auth()->id(), $patient_user->id])->update(['channel_name' => $cn, 'agora_token' => $token]);

            $this->oneSignalNoti($patient_user->device_token, auth()->user()->name, $token, $cn, $appID);

            return response()->json(['msg' => null, 'data' => ['agora_token' => $token, 'cn' => $cn, 'appId' => $appID], 'success' => true], 200);
        }

        return response()->json(['success' => false, 'msg' => 'Token And ID Not Available'], 404);
    }

    public function oneSignalNoti($userid, $sub, $agoraToken, $channelId, $appId)
    {
        $settings = Setting::select('patient_app_id', 'patient_api_key', 'patient_auth_key')->first();
        try {
            Config::set('onesignal.app_id', $settings->patient_app_id);
            Config::set('onesignal.rest_api_key', $settings->patient_api_key);
            Config::set('onesignal.user_auth_key', $settings->patient_auth_key);
            $data = [
                'name' => $sub,
                'id' => auth()->user()->id,
                'channelId' => $channelId,
                'appId' => $appId,
                'agoraToken' => $agoraToken,
            ];
            OneSignal::sendNotificationToUser(
                $sub,
                $userid,
                $url = null,
                $data = $data,
                $schedule = null,
                $headings = null,
            );
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function apiUpdatePatientVCallSwitch(Request $request)
    {
        $doctor = Doctor::where('user_id', auth()->user()->id)->first();
        $doctor->patient_vcall = $request->patient_vcall;
        $doctor->save();

        return response(['success' => true, 'msg' => 'Updated'], 200);
    }

    public function sendTestNotification(Request $request)
    {
        $request->validate([
            'email' => 'bail|required|email',
            'role' => 'bail|required|in:doctor,patient',
        ]);

        try {
            $res = (new CustomController)->sendTestNotification($request->email, $request->role);

            return response(['success' => true, 'msg' => $res], 200);
        } catch (\Throwable $th) {
            return response(['success' => false, 'msg' => $res ?? 'Unknown Error'], 404);
        }
    }

    public function apiSendMessageToPatientNotificationTrigger(Request $request)
    {
        $request->validate([
            'content' => 'bail|required',
            'to_device_token' => 'bail|required',
        ]);

        if ($request->to_device_token == 'N_A' || $request->to_device_token == '') {
            return response()->json(['success' => false, 'message' => 'Device token not found']);
        }

        $setting = Setting::first();
        if ($setting->patient_notification == 1) {

            $receiver_user = User::where('device_token', $request->to_device_token)->first();
            $receiver_doctor_id = Doctor::where('user_id', auth()->user()->id)->value('id');

            if (! $receiver_user) {
                return response()->json(['success' => false, 'message' => 'Receiver user not found']);
            }

            try {
                $client = new OneSignalClient(
                    $setting->patient_app_id,
                    $setting->patient_api_key,
                    $setting->patient_auth_key
                );

                $client->async()->sendNotificationCustom([
                    'headings' => ['en' => auth()->user()->name],
                    'contents' => ['en' => $request->content],
                    'include_player_ids' => [$receiver_user->device_token],
                    'data' => [
                        'screen' => 'screen',
                        'userId' => auth()->user()->id,
                        'doctorId' => $receiver_doctor_id,
                        'userToken' => auth()->user()->device_token,
                        'userImage' => auth()->user()->image,
                        'userName' => auth()->user()->name,
                    ],
                ]);
            } catch (\Exception $e) {
                info('OneSignal Error: '.$e->getMessage());
            }
        }

        return response()->json(['success' => true, 'message' => 'Notification sent successfully']);
    }
}
