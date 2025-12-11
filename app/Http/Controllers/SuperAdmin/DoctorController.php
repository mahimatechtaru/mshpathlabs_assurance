<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use App\Models\Appointment;
use App\Models\Category;
use App\Models\Country;
use App\Models\Doctor;
use App\Models\DoctorSubscription;
use App\Models\Expertise;
use App\Models\Hospital;
use App\Models\Offer;
use App\Models\Setting;
use App\Models\Settle;
use App\Models\Subscription;
use App\Models\Treatments;
use App\Models\User;
use App\Models\WorkingHour;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('doctor_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $doctors = Doctor::with('expertise')->orderBy('id', 'desc')->get();
        foreach ($doctors as $doctor) {
            $doctor->user = User::find($doctor->user_id);
        }

        return view('superAdmin.doctor.doctor', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('doctor_add'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $countries = Country::get();
        $treatments = Treatments::whereStatus(1)->get();
        $treat = [];
        $categories = [];
        $expertieses = [];
        $treat = Treatments::whereStatus(1)->first();
        if ($treat) {
            $categories = Category::whereStatus(1)->where('treatment_id', $treat->id)->get();
            $cat = Category::whereStatus(1)->where('treatment_id', $treat->id)->first();
            if ($cat) {
                $expertieses = Expertise::whereStatus(1)->where('category_id', $cat->id)->get();
            }
        }
        $hospitals = Hospital::whereStatus(1)->get();

        return view('superAdmin.doctor.create_doctor', compact('countries', 'treatments', 'hospitals', 'categories', 'expertieses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required|unique:doctor',
            'email' => 'bail|required|email|unique:users',
            'treatment_id' => 'bail|required',
            'category_id' => 'bail|required',
            'dob' => 'bail|required',
            'gender' => 'bail|required',
            'phone' => 'bail|required|digits_between:6,12',
            'expertise_id' => 'bail|required',
            'timeslot' => 'bail|required',
            'start_time' => 'bail|required',
            'end_time' => 'bail|required|after:start_time',
            'hospital_id' => 'bail|required',
            'desc' => 'required',
            'appointment_fees' => 'required|numeric',
            'experience' => 'bail|required|numeric',
            'custom_timeslot' => 'bail|required_if:timeslot,other',
            'commission_amount' => 'bail|required_if:based_on,commission',
            'password' => 'sometimes|min:6',
        ]);
        $data = $request->all();
        if (isset($data['password']) && ($data['password'] != '' || $data['password'] != null)) {
            $password = $data['password'];
        } else {
            $password = mt_rand(100000, 999999);
        }
        unset($data['password']);
        $setting = Setting::first();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($password),
            'verify' => 1,
            'phone' => $data['phone'],
            'phone_code' => $data['phone_code'],
            'image' => 'defaultUser.png',
        ],
            [
                'image.max' => 'The Image May Not Be Greater Than 1 MegaBytes.',
            ]);
        $message1 = 'Dear Doctor your password is : '.$password;
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
            Mail::to($user->email)->send(new SendMail($message1, 'Doctor Password'));
        } catch (\Exception $e) {
            info($e);
        }
        $user->assignRole('doctor');
        $data['user_id'] = $user->id;
        $data['start_time'] = strtolower(Carbon::parse($data['start_time'])->format('h:i a'));
        $data['end_time'] = strtolower(Carbon::parse($data['end_time'])->format('h:i a'));
        if ($request->hasFile('image')) {
            $data['image'] = (new CustomController)->imageUpload($request->image);
        } else {
            $data['image'] = 'defaultUser.png';
        }
        $education = [];
        for ($i = 0; $i < count($data['degree']); $i++) {
            $temp['degree'] = $data['degree'][$i];
            $temp['college'] = $data['college'][$i];
            $temp['year'] = $data['year'][$i];
            array_push($education, $temp);
        }
        $data['education'] = json_encode($education);
        $certificate = [];
        for ($i = 0; $i < count($data['certificate']); $i++) {
            $temp1['certificate'] = $data['certificate'][$i];
            $temp1['certificate_year'] = $data['certificate_year'][$i];
            array_push($certificate, $temp1);
        }
        $data['certificate'] = json_encode($certificate);
        $data['since'] = Carbon::now(env('timezone'))->format('Y-m-d , h:i A');
        $data['status'] = 1;
        $data['subscription_status'] = 1;
        $data['is_filled'] = 1;
        $data['hospital_id'] = implode(',', $request->hospital_id);
        if ($data['commission_amount'] == '') {
            $data['commission_amount'] = null;
        }
        $doctor = Doctor::create($data);
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
        $start_time = strtolower($doctor->start_time);
        $end_time = strtolower($doctor->end_time);
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

        return redirect('doctor')->withStatus(__('Doctor created successfully..!!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function show($id, $name, $with)
    {
        (new CustomController)->cancel_max_order();
        $doctor = Doctor::with('expertise')->find($id);
        $currency = Setting::first()->currency_symbol;
        if ($with == 'dashboard') {
            $totalUsers = User::doesntHave('roles')->where('doctor_id', $id)->count();
            $totalAppointments = Appointment::where('doctor_id', $id)->get();

            return view('superAdmin.doctor.show_doctor', compact('doctor', 'currency', 'totalUsers', 'totalAppointments'));
        } elseif ($with == 'appointment') {
            return view('superAdmin.doctor.doctor_appointment', compact('doctor'));
        } elseif ($with == 'patients') {
            $patients = User::doesntHave('roles')->where('doctor_id', $id)->get();

            return view('superAdmin.doctor.doctor_patients', compact('doctor', 'patients'));
        } elseif ($with == 'schedule') {
            $doctor->workingHours = WorkingHour::where('doctor_id', $id)->get();
            $doctor->firstHours = WorkingHour::where('doctor_id', $id)->first();

            return view('superAdmin.doctor.doctor_schedule', compact('doctor'));
        } elseif ($with == 'finance') {
            if ($doctor->based_on == 'commission') {
                $now = Carbon::today();
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

                return view('superAdmin.doctor.finance', compact('doctor', 'appointments', 'currency', 'settels'));
            }
            if ($doctor->based_on == 'subscription') {
                $subscriptions = DoctorSubscription::with(['Subscription', 'doctor'])->where('doctor_id', $id)->orderBy('id', 'DESC')->get();

                return view('superAdmin.doctor.finance', compact('doctor', 'subscriptions', 'currency'));
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('doctor_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $doctor = Doctor::find($id);
        $doctor->user = User::find($doctor->user_id);
        $countries = Country::get();
        $treatments = Treatments::whereStatus(1)->get();
        $categories = Category::whereStatus(1)->get();
        $expertieses = Expertise::whereStatus(1)->get();
        $hospitals = Hospital::get();
        $doctor['start_time'] = Carbon::parse($doctor['start_time'])->format('H:i');
        $doctor['end_time'] = Carbon::parse($doctor['end_time'])->format('H:i');
        $doctor['hospital_id'] = explode(',', $doctor->hospital_id);

        return view('superAdmin.doctor.edit_doctor', compact('doctor', 'countries', 'treatments', 'hospitals', 'categories', 'expertieses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'bail|required|unique:doctor,name,'.$id.',id',
            'treatment_id' => 'bail|required',
            'category_id' => 'bail|required',
            'dob' => 'bail|required',
            'gender' => 'bail|required',
            'phone' => 'bail|required|digits_between:6,12',
            'expertise_id' => 'bail|required',
            'timeslot' => 'bail|required',
            'start_time' => 'bail|required',
            'end_time' => 'bail|required|after:start_time',
            'hospital_id' => 'bail|required',
            'desc' => 'required',
            'appointment_fees' => 'required|numeric',
            'experience' => 'bail|required|numeric',
            'image' => 'bail|mimes:jpeg,png,jpg|max:1000',
            'custom_timeslot' => 'bail|required_if:timeslot,other',
            'commission_amount' => 'bail|required_if:based_on,commission',
            'password' => 'sometimes|min:6',
        ],
            [
                'image.max' => 'The Image May Not Be Greater Than 1 MegaBytes.',
            ]);
        $doctor = Doctor::find($id);
        $data = $request->all();

        $data['start_time'] = Carbon::parse($data['start_time'])->format('h:i A');
        $data['end_time'] = Carbon::parse($data['end_time'])->format('h:i A');
        if ($request->hasFile('image')) {
            (new CustomController)->deleteFile($doctor->image);
            $data['image'] = (new CustomController)->imageUpload($request->image);
        }
        $education = [];
        for ($i = 0; $i < count($data['degree']); $i++) {
            $temp['degree'] = $data['degree'][$i];
            $temp['college'] = $data['college'][$i];
            $temp['year'] = $data['year'][$i];
            array_push($education, $temp);
        }
        $data['education'] = json_encode($education);
        $certificate = [];
        for ($i = 0; $i < count($data['certificate']); $i++) {
            $temp1['certificate'] = $data['certificate'][$i];
            $temp1['certificate_year'] = $data['certificate_year'][$i];
            array_push($certificate, $temp1);
        }
        $data['certificate'] = json_encode($certificate);
        $data['is_filled'] = 1;
        $data['custom_timeslot'] = $request->custom_time == '' ? null : $request->custom_time;
        $data['hospital_id'] = implode(',', $request->hospital_id);
        if ($request->based_on == 'subscription') {
            if (! DoctorSubscription::where('doctor_id', $id)->exists()) {
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
        }
        if ($data['commission_amount'] == '') {
            $data['commission_amount'] = null;
        }

        if (isset($data['password']) && ($data['password'] != '' || $data['password'] != null)) {
            $password = Hash::make($data['password']);
            User::find($doctor->user_id)->update(['password' => $password]);
        }
        unset($data['password']);
        $doctor->update($data);

        return redirect('doctor')->withStatus(__('Doctor updated successfully..!!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('doctor_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $offers = Offer::all();
        foreach ($offers as $value) {
            $doctor_id = explode(',', $value['doctor_id']);
            if (($key = array_search($id, $doctor_id)) !== false) {
                return response(['success' => false, 'data' => 'This doctor connected with Offer, Please remove doctor from offer first.']);
            }
        }
        $id = Doctor::find($id);
        $user = User::find($id->user_id);
        $user->removeRole('doctor');
        $user->delete();
        (new CustomController)->deleteFile($id->image);
        $id->delete();

        return response(['success' => true]);
    }

    public function display_timeslot($id)
    {
        $work = WorkingHour::find($id);

        return response(['success' => true, 'data' => $work]);
    }

    public function edit_timeslot($id)
    {
        $work = WorkingHour::find($id);

        return response(['success' => true, 'data' => $work]);
    }

    public function update_timeslot(Request $request)
    {
        $data = $request->all();
        $work = WorkingHour::find($request->working_id);
        $master = [];
        for ($i = 0; $i < count($request->start_time); $i++) {
            $temp['start_time'] = strtolower($request->start_time[$i]);
            $temp['end_time'] = strtolower($request->end_time[$i]);
            array_push($master, $temp);
        }
        $data['period_list'] = json_encode($master);
        $data['status'] = $request->has('status') ? 1 : 0;
        $work->update($data);

        return redirect()->back();
    }

    public function change_password(Request $request)
    {
        $request->validate([
            'new_password' => 'bail|required|min:6',
            'confirm_new_password' => 'bail|required|min:6|same:new_password',
        ]);
        User::find(Doctor::find($request->doctor_id)->user_id)->update(['password' => Hash::make($request->new_password)]);

        return redirect()->back()->withStatus(__('password change successfully..!!'));
    }

    public function change_status(Request $reqeust)
    {
        $doctor = Doctor::find($reqeust->id);
        $data['status'] = $doctor->status == 1 ? 0 : 1;
        $doctor->update($data);

        return response(['success' => true]);
    }
}
