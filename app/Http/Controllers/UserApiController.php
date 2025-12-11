<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SuperAdmin\CustomController;
use App\Mail\SendMail;
use App\Models\Appointment;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Doctor;
use App\Models\Faviroute;
use App\Models\Hospital;
use App\Models\HospitalGallery;
use App\Models\Insurer;
use App\Models\Medicine;
use App\Models\MedicineChild;
use App\Models\Notification;
use App\Models\NotificationTemplate;
use App\Models\Offer;
use App\Models\Pharmacy;
use App\Models\PharmacySettle;
use App\Models\Prescription;
use App\Models\PurchaseMedicine;
use App\Models\Review;
use App\Models\Setting;
use App\Models\Treatments;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\VideoCallHistory;
use Berkayk\OneSignal\OneSignalClient;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use OneSignal;
use Spatie\Permission\Models\Role;
use Stripe\StripeClient;

include 'RtcTokenBuilder.php';

class UserApiController extends Controller
{
    public function apiLogin(Request $request)
    {
        $request->validate([
            'email' => 'bail|required|email',
            'password' => 'bail|required|min:6',
        ]);

        $user = ([
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if (Auth::attempt($user)) {
            $user = Auth::user();
            if (! $user->hasAnyRole(Role::all())) {
                if ($user->status == 1) {
                    if (isset($request->device_token)) {
                        $user->device_token = $request->device_token;
                        $user->save();
                    }
                    if ($user['verify'] == 1) {
                        $user['token'] = $user->createToken('doctro')->accessToken;
                        $user->makeHidden('roles');

                        return response()->json(['success' => true, 'data' => $user, 'msg' => 'successfully login'], 200);
                    } else {
                        (new CustomController)->sendOtp($user);

                        return response(['success' => true, 'data' => $user, 'msg' => 'Otp send in your account']);
                    }
                } else {
                    return response(['success' => false, 'msg' => 'You are blocked please contact to admin.']);
                }
            } else {
                return response()->json(['success' => false, 'msg' => 'Only Patient Can login'], 401);
            }
        } else {
            return response()->json(['success' => false, 'msg' => 'Invalid Email & Password.']);
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

    // Register
    public function apiRegister(Request $request)
    {
        $request->validate([
            'name' => 'bail|required',
            'email' => 'bail|required|email|unique:users',
            'dob' => 'bail|required|date_format:Y-m-d',
            'gender' => 'bail|required',
            'phone' => 'bail|required',
            'phone_code' => 'bail|required',
            'password' => 'bail|required|min:6',
        ]);
        $data = $request->all();
        $verification = Setting::first()->verification;
        $verify = $verification == 1 ? 0 : 1;
        $data['password'] = Hash::make($request->password);
        $data['verify'] = $verify;
        $data['image'] = 'defaultUser.png';
        $data['status'] = 1;
        $user = User::create($data);
        if ($user->verify == 1) {
            if (Auth::attempt(['email' => $user['email'], 'password' => $request->password])) {
                $user['token'] = $user->createToken('doctor')->accessToken;

                return response()->json(['success' => true, 'data' => $user, 'msg' => 'successfully register'], 200);
            }
        } else {
            return (new CustomController)->sendOtp($user);

            return response()->json(['success' => false, 'data' => $user, 'msg' => 'OTP send into your account'], 200);
        }
    }

    public function apiCheckOtp(Request $request)
    {
        $request->validate([
            'user_id' => 'bail|required',
            'otp' => 'bail|required|min:4',
        ]);
        $user = User::find($request->user_id);
        if ($user) {
            if ($user->otp == $request->otp) {
                $user->verify = 1;
                $user->save();
                $user['token'] = $user->createToken('doctro')->accessToken;

                return response(['success' => true, 'data' => $user, 'msg' => 'SuccessFully verify your account...!!']);
            } else {
                return response(['success' => false, 'msg' => 'Please Enter Valid Otp.']);
            }
        } else {
            return response(['success' => false, 'msg' => 'Oops...user not found..!!']);
        }
    }

    public function apiResendOtp($user_id)
    {
        $user = User::find($user_id);
        if ($user) {
            (new CustomController)->sendOtp($user);

            return response()->json(['success' => true, 'msg' => 'OTP resend']);
        } else {
            return response()->json(['success' => false, 'msg' => 'User not found']);
        }
    }

    // Treatment Wise Doctor
    public function apiTreatmentDoctor(Request $request, $treatment_id)
    {
        $request->validate([
            'lat' => 'bail|required',
            'lang' => 'bail|required',
        ]);
        $doctor = Doctor::with('treatment:id,name')->whereStatus(1)->where([['is_filled', 1], ['treatment_id', $treatment_id]])->whereSubscriptionStatus(1)->get(['id', 'status', 'image', 'name', 'treatment_id', 'hospital_id'])->makeHidden(['rate', 'review']);
        $data = $request->all();
        $doctors = $this->getNearDoctor($doctor, $data['lat'], $data['lang']);
        foreach ($doctors as $doctor) {
            $doctor->is_faviroute = $this->checkFavourite($doctor->id);
            unset($doctor->hospital_id);
        }

        return response(['success' => true, 'data' => $doctors]);
    }

    public function apiDoctors(Request $request)
    {
        $request->validate([
            'lat' => 'bail|required',
            'lang' => 'bail|required',
        ]);
        $doctor = Doctor::with('treatment:id,name')->whereStatus(1)->where('is_filled', 1)->whereSubscriptionStatus(1)->get(['id', 'status', 'image', 'name', 'treatment_id', 'hospital_id'])->makeHidden(['rate', 'review']);
        $data = $request->all();
        $doctors = $this->getNearDoctor($doctor, $data['lat'], $data['lang']);
        foreach ($doctors as $doctor) {
            $doctor->is_faviroute = $this->checkFavourite($doctor->id);
            unset($doctor->hospital_id);
        }

        return response(['success' => true, 'data' => $doctors, 'msg' => 'All Doctors']);
    }

    public function apiTreatments()
    {
        $treatments = Treatments::whereStatus(1)->get(['id', 'name', 'image']);

        return response(['success' => true, 'data' => $treatments, 'msg' => 'All Treatments']);
    }

    public function apiOffers()
    {
        $offers = Offer::whereStatus(1)->get(['id', 'name', 'image', 'offer_code', 'discount', 'is_flat', 'discount_type', 'flatDiscount']);

        return response(['success' => true, 'data' => $offers, 'msg' => 'All Offers']);
    }

    public function apiNearByDoctor(Request $request)
    {
        $request->validate([
            'lat' => 'bail|required',
            'lang' => 'bail|required',
        ]);
        $data = $request->all();
        if (isset($data['lat']) && isset($data['lang'])) {
            $doctor = Doctor::whereStatus(1)->where('is_filled', 1)->whereSubscriptionStatus(1)->get(['id', 'name', 'image', 'hospital_id'])->makeHidden(['rate', 'review']);
            $doctors = $this->getNearDoctor($doctor, $data['lat'], $data['lang']);

            return response(['success' => true, 'data' => $doctors, 'msg' => 'show all doctors']);
        }
    }

    public function distance($lat1, $lang1, $lat2, $lang2)
    {
        $lat1 = $lat1;
        $lon1 = $lang1;
        $lat2 = $lat2;
        $lon2 = $lang2;
        $unit = 'K';
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            $distance = 0;
        } else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);
            if ($unit == 'K') {
                $distance = $miles * 1.609344;
            } elseif ($unit == 'N') {
                $distance = $miles * 0.8684;
            } else {
                $distance = $miles;
            }
        }

        return $distance;
    }

    public function apiSingleDoctor(Request $request, $id)
    {
        $request->validate([
            'lat' => 'bail|required',
            'lang' => 'bail|required',
        ]);
        $doctor = Doctor::with(['treatment:id,name', 'expertise:id,name'])->find($id)->makeHidden(['created_at', 'updated_at', 'timeslot', 'dob', 'gender', 'timeslot', 'since', 'status', 'based_on']);
        $radius = Setting::first()->radius;
        $hospitals = Hospital::whereStatus(1)->GetByDistance($request->lat, $request->lang, $radius)->pluck('id')->toArray();

        $h = explode(',', $doctor->hospital_id);
        if (! empty(array_intersect($hospitals, $h))) {
            $hss = array_intersect($hospitals, $h);
            $array = [];
            foreach ($hss as $hospital) {
                $h = Hospital::find($hospital);
                $temp['hospital_distance'] = number_format($this->distance($h['lat'], $h['lng'], $request->lat, $request->lang), 2);
                $temp['hospital_details'] = $h->makeHidden(['lat', 'lng', 'created_at', 'updated_at', 'status']);
                $temp['hospital_gallery'] = HospitalGallery::where('hospital_id', $h->id)->get(['image']);
                array_push($array, $temp);
                $doctor->hospital_id = $array;
            }
        } else {
            $newArr = array_merge($hospitals, $h);
            $array = [];
            if (count($newArr) > 1) {
                foreach ($newArr as $hospital) {
                    $h = Hospital::find($hospital);
                    $temp['hospital_distance'] = number_format($this->distance($h['lat'], $h['lng'], $request->lat, $request->lang), 2);
                    $temp['hospital_details'] = $h->makeHidden(['lat', 'lng', 'created_at', 'updated_at', 'status']);
                    $temp['hospital_gallery'] = HospitalGallery::where('hospital_id', $h->id)->get(['image']);
                    array_push($array, $temp);
                    $doctor->hospital_id = $array;
                }
            } else {
                $doctor->hospital_id = [];
            }
        }
        $doctor['reviews'] = Review::with('user:id,name,image')->where('doctor_id', $id)->get();

        return response(['success' => true, 'data' => $doctor, 'msg' => 'single doctor details']);
    }

    public function apiTimeslot(Request $request)
    {
        $request->validate([
            'date' => 'bail|required|date_format:Y-m-d',
            'doctor_id' => 'bail|required|numeric',
        ]);
        $data = $request->all();
        $timeslots = (new CustomController)->timeSlot($data['doctor_id'], $data['date']);

        return response(['success' => true, 'data' => $timeslots, 'msg' => 'Doctor Timeslot']);
    }

    public function apiBooking(Request $request)
    {
        $request->validate([
            'appointment_for' => 'bail|required',
            'illness_information' => 'bail|required',
            'patient_name' => 'bail|required',
            'age' => 'bail|required|numeric',
            'patient_address' => 'bail|required',
            'phone_no' => 'bail|required|numeric|digits_between:6,12',
            'drug_effect' => 'bail|required',
            'note' => 'bail|nullable',
            'date' => 'bail|required',
            'time' => 'bail|required',
            'doctor_id' => 'bail|required',
            'amount' => 'bail|required',
            'payment_type' => 'bail|required',
            'payment_status' => 'bail|required',
            'hospital_id' => 'bail|required',
            'policy_insurer_name' => 'bail|required_if:is_insured,1',
            'policy_number' => 'bail|required_if:is_insured,1',
        ]);
        $data = $request->all();
        $data['appointment_id'] = '#'.rand(100000, 999999);
        $data['user_id'] = auth()->user()->id;
        $data['appointment_status'] = 'pending';
        $data['is_from'] = '0';
        if (isset($data['report_image'])) {
            $report = [];
            for ($i = 0; $i < count($data['report_image']); $i++) {
                $img = $request->report_image[$i];
                $img = str_replace('data:image/png;base64,', '', $img);
                $img = str_replace(' ', '+', $img);
                $data1 = base64_decode($img);
                $Iname = uniqid();
                $file = public_path('/images/upload/').$Iname.'.png';
                $success = file_put_contents($file, $data1);
                array_push($report, $Iname.'.png');
            }
            $data['report_image'] = json_encode($report);
        }
        if ($data['payment_type'] == 'STRIPE') {
            $paymentSetting = Setting::find(1);
            $stripe_sk = $paymentSetting->stripe_secret_key;
            $stripe = new StripeClient($stripe_sk);
            $charge = $stripe->charges->create([
                'amount' => $data['amount'] * 100,
                'currency' => Setting::first()->currency_code,
                'source' => $request->payment_token,
            ]);
            $data['payment_token'] = $charge->id;
        }
        $doctor = Doctor::find($data['doctor_id']);
        if ($doctor->based_on == 'commission') {
            $comm = $data['amount'] * $doctor->commission_amount;
            $data['admin_commission'] = intval($comm / 100);
            $data['doctor_commission'] = intval($data['amount'] - $data['admin_commission']);
        }
        $data['payment_type'] = strtoupper($data['payment_type']);
        $appointment = Appointment::create($data);

        $setting = Setting::first();
        // doctor booked appointment
        $notification_template1 = NotificationTemplate::where('title', 'doctor book appointment')->first();

        $placeholders = [
            '{{doctor_name}}' => $doctor->name,
            '{{appointment_id}}' => $appointment->appointment_id,
            '{{date}}' => $appointment->date,
            '{{user_name}}' => auth()->user()->name,
            '{{app_name}}' => $setting->business_name,
        ];

        $msg1 = $notification_template1->msg_content;
        $mail1 = $notification_template1->mail_content;

        $placeholder_keys = array_keys($placeholders);
        $placeholder_values = array_values($placeholders);
        $mail1 = str_ireplace($placeholder_keys, $placeholder_values, $mail1);
        $msg1 = str_ireplace($placeholder_keys, $placeholder_values, $msg1);

        $doctor_user = User::where('id', $doctor->user_id)->first();
        if ($setting->doctor_mail == 1) {
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
                Mail::to($doctor_user->email)->send(new SendMail($mail1, $notification_template1->subject));
            } catch (\Exception $e) {
                info($e->getMessage());
            }
        }

        if ($setting->doctor_notification == 1) {
            try {

                $client = new OneSignalClient($setting->doctor_app_id, $setting->doctor_api_key, $setting->doctor_auth_key);
                $client->async()->sendNotificationCustom([
                    'headings' => ['en' => $setting->business_name],
                    'contents' => ['en' => $msg1],
                    'include_player_ids' => [$doctor_user->device_token],
                ]);
            } catch (\Exception $e) {
                info('OneSignal Error: '.$e->getMessage());
            }
        }

        $doctor_notification = [];
        $doctor_notification['user_id'] = auth()->user()->id;
        $doctor_notification['doctor_id'] = $appointment->doctor_id;
        $doctor_notification['user_type'] = 'doctor';
        $doctor_notification['title'] = 'create appointment';
        $doctor_notification['message'] = $msg1;
        Notification::create($doctor_notification);

        // create Appointment to user
        $notification_template = NotificationTemplate::where('title', 'create appointment')->first();

        $placeholders = [
            '{{user_name}}' => auth()->user()->name,
            '{{appointment_id}}' => $appointment->appointment_id,
            '{{date}}' => $appointment->date,
            '{{time}}' => $appointment->time,
            '{{app_name}}' => $setting->business_name,
        ];

        $msg1 = $notification_template->msg_content;
        $mail1 = $notification_template->mail_content;

        $placeholder_keys = array_keys($placeholders);
        $placeholder_values = array_values($placeholders);
        $mail1 = str_ireplace($placeholder_keys, $placeholder_values, $mail1);
        $msg1 = str_ireplace($placeholder_keys, $placeholder_values, $msg1);

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
                Mail::to(auth()->user()->email)->send(new SendMail($mail1, $notification_template->subject));
            } catch (\Exception $e) {
                info($e->getMessage());
            }
        }

        if ($setting->patient_notification == 1) {
            try {
                $client = new OneSignalClient($setting->patient_app_id, $setting->patient_api_key, $setting->patient_auth_key);
                $client->async()->sendNotificationCustom([
                    'headings' => ['en' => $setting->business_name],
                    'contents' => ['en' => $msg1],
                    'include_player_ids' => [auth()->user()->device_token],
                ]);
            } catch (\Exception $e) {
                info('OneSignal Error: '.$e->getMessage());
            }

            (new CustomController)->scheduledReminderNotification($appointment->id);
        }

        $user_notification = [];
        $user_notification['user_id'] = auth()->user()->id;
        $user_notification['doctor_id'] = $appointment->doctor_id;
        $user_notification['user_type'] = 'user';
        $user_notification['title'] = 'create appointment';
        $user_notification['message'] = $msg1;
        Notification::create($user_notification);

        return response(['success' => true, 'data' => $appointment->appointment_id, 'msg' => 'Booking is successfully waiting for doctor confirmation']);
    }

    public function apiAppointments()
    {
        (new CustomController)->cancel_max_order();
        $upcoming = [];
        $pending = [];
        $past = [];
        $appoint = [];
        $appointments = Appointment::with(['hospital:id,address,name'])->where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get(['id', 'date', 'time', 'appointment_status', 'patient_name', 'doctor_id', 'appointment_id', 'hospital_id']);
        foreach ($appointments as $appointment) {
            if ($appointment->hospital == null) {
                unset($appointment['hospital']);
                $appointment['hospital'] = (object) [];
                $appointment['hospital_id'] = 0;
            }
            $appointment->doctor = Doctor::with(['treatment:id,name'])->where('id', $appointment->doctor_id)->first(['id', 'name', 'image', 'treatment_id'])->makeHidden(['rate', 'review']);
            $appointment->prescription = Prescription::where('appointment_id', $appointment->id)->exists();
            $appointment->timming = Carbon::parse($appointment['date'].' '.$appointment['time'])->setTimezone(env('timezone'));
            if ($appointment->timming > Carbon::now(env('timezone')) && $appointment->appointment_status == 'approve') {
                unset($appointment['timming']);
                array_push($upcoming, $appointment);
            } elseif ($appointment->timming > Carbon::now(env('timezone')) && $appointment->appointment_status == 'pending') {
                unset($appointment['timming']);
                array_push($pending, $appointment);
            } else {
                unset($appointment['timming']);
                array_push($past, $appointment);
            }
        }
        $appoint['upcoming_appointment'] = $upcoming;
        $appoint['pending_appointment'] = $pending;
        $appoint['past_appointment'] = $past;

        return response(['success' => true, 'data' => $appoint, 'msg' => 'Appointment details']);
    }

    public function apiAppointmentPrescription($id)
    {
        (new CustomController)->cancel_max_order();
        $appointment = Appointment::find($id, 'id', 'date', 'time', 'patient_name', 'doctor_id');
        $appointment->doctor = Doctor::with('treatment:id,name')->where('id', $appointment->doctor_id)->first(['id', 'name', 'image', 'treatment_id']);
        $appointment->prescription = Prescription::where('appointment_id', $id)->first();
        $appointment->prescription['pdfPath'] = url('prescription/upload/'.$appointment->prescription['pdf']);

        return response(['success' => true, 'data' => $appointment, 'msg' => 'Doctor Prescription']);
    }

    public function apiSetting()
    {
        $setting = Setting::first(['cod', 'doctor_app_id', 'paypal', 'stripe', 'razor', 'flutterwave', 'paystack', 'stripe_public_key', 'stripe_secret_key', 'razor_key', 'flutterwave_encryption_key', 'patient_app_id', 'playstore', 'appstore', 'privacy_policy', 'about_us', 'agora_app_id', 'agora_app_certificate', 'cancel_reason', 'flutterwave_key', 'paystack_public_key', 'currency_symbol', 'currency_code', 'isLiveKey', 'paypal_client_id', 'paypal_secret_key'])->makeHidden(['companyWhite', 'logo', 'favicon']);
        if (! auth('api')->check()) {
            $setting = $setting->makeHidden(['stripe_public_key', 'stripe_secret_key', 'razor_key', 'flutterwave_encryption_key', 'agora_app_id', 'agora_app_certificate', 'flutterwave_key', 'paystack_public_key', 'paypal_client_id', 'paypal_secret_key']);
        }

        return response(['success' => true, 'data' => $setting, 'msg' => 'Setting']);
    }

    public function apiBlogs()
    {
        $blogs = Blog::where([['status', 1], ['release_now', 1]])->orderBy('id', 'DESC')->get()->makeHidden(['created_at', 'updated_at', 'status', 'release_now']);

        return response(['success' => true, 'data' => $blogs, 'msg' => 'Blogs']);
    }

    public function apiSingleBlog($id)
    {
        $blogs = Blog::where('id', $id)->orderBy('id', 'DESC')->first()->makeHidden(['created_at', 'updated_at', 'status', 'release_now']);

        return response(['success' => true, 'data' => $blogs, 'msg' => 'Single Blog Details']);
    }

    public function apiUpdateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'dob' => 'required',
            'gender' => 'required',
        ]);
        $id = auth()->user();
        $id->update($request->all());

        return response(['success' => true, 'msg' => 'update successfully']);
    }

    public function apiUpdateImage(Request $request)
    {
        $request->validate([
            'image' => 'bail|required|mimes:jpeg,png,jpg|max:1000',

        ]);
        $id = auth()->user();
        if (isset($request->image)) {
            $img = $request->image;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data1 = base64_decode($img);
            $Iname = uniqid();
            $file = public_path('/images/upload/').$Iname.'.png';
            $success = file_put_contents($file, $data1);
            $data['image'] = $Iname.'.png';
        }
        $id->update($data);

        return response(['success' => true, 'data' => 'image updated succssfully..!!']);
    }

    public function apiPharmacy()
    {
        $pharamacies = Pharmacy::whereStatus(1)->orderBy('id', 'DESC')->get(['id', 'name', 'image', 'address']);

        return response(['success' => true, 'data' => $pharamacies, 'msg' => 'All phamracy']);
    }

    public function apiSinglePharmacy($id)
    {
        $pharmacy = Pharmacy::find($id);
        $pharmacy->medicine = Medicine::where('pharmacy_id', $id)->get();

        return response(['success' => true, 'data' => $pharmacy, 'msg' => 'Single Phamracy Details']);
    }

    public function apiSingleMedicine($id)
    {
        $medicine = Medicine::find($id);

        return response(['success' => true, 'data' => $medicine, 'msg' => 'Single Medicine Details']);
    }

    public function apiBookMedicine(Request $request)
    {
        $request->validate([
            'pharmacy_id' => 'bail|required',
            'amount' => 'bail|required',
            'payment_type' => 'bail|required',
            'payment_status' => 'bail|required',
            'medicines' => 'bail|required',
        ]);
        $data = $request->all();
        if (isset($data['pdf'])) {
            $test = explode('.', $data['pdf']);
            $ext = end($test);
            $name = uniqid().'.'.'pdf';
            $location = public_path().'/prescription/upload';
            $data['pdf']->move($location, $name);
            $data['pdf'] = $name;
        }
        $data['user_id'] = auth()->user()->id;
        $data['medicine_id'] = '#'.rand(100000, 999999);
        $data['payment_type'] = strtoupper($request->payment_type);
        $pharmacy = Pharmacy::find($data['pharmacy_id']);
        $commission = $pharmacy->commission_amount;
        $com = $data['amount'] * $commission;
        $data['admin_commission'] = $com / 100;
        $data['pharmacy_commission'] = $data['amount'] - $data['admin_commission'];
        $purchase = PurchaseMedicine::create($data);
        foreach (json_decode($data['medicines']) as $value) {
            $master = [];
            $master['purchase_medicine_id'] = $purchase->id;
            $master['medicine_id'] = $value->id;
            $master['price'] = $value->price;
            $master['qty'] = $value->qty;
            $medicine = Medicine::find($value->id);
            $use_stock = $medicine->use_stock + $value->qty;
            Medicine::find($value->id)->update(['use_stock' => $use_stock]);
            MedicineChild::create($master);
        }

        $settle = [];
        $settle['purchase_medicine_id'] = $purchase->id;
        $settle['pharmacy_id'] = $purchase->pharmacy_id;
        $settle['pharmacy_amount'] = $purchase->pharmacy_commission;
        $settle['admin_amount'] = $purchase->admin_commission;
        $settle['payment'] = $purchase->payment_type == 'COD' ? 0 : 1;
        $settle['pharmacy_status'] = 0;
        PharmacySettle::create($settle);

        return response(['success' => true, 'msg' => 'Medicine booked']);
    }

    public function app_medicine_flutter_payment($medicine_id)
    {
        $medicine = PurchaseMedicine::find($medicine_id);
        $medicine->customer = auth()->user();

        return view('app_flutter.medicine_flutter', compact('medicine'));
    }

    public function app_medicine_transction_confirm(Request $request, $appointment_id)
    {
        $appointment = PurchaseMedicine::find($appointment_id);
        $id = $request->input('transaction_id');
        if ($request->input('status') == 'successful') {
            $appointment->payment_token = $id;
            $appointment->payment_status = 1;
            $appointment->save();

            return view('app_flutter.success');
        } else {
            return view('app_flutter.cancel');
        }
    }

    public function apiMedicines()
    {
        $medicines = PurchaseMedicine::with('address')->where('user_id', auth()->user()->id)->get()->makeHidden(['updated_at']);
        foreach ($medicines as $medicine) {
            $medicine['pharmacy_details'] = Pharmacy::find($medicine->pharmacy_id, ['id', 'name', 'image', 'address']);
        }

        return response(['success' => true, 'msg' => 'purchased medicine details', 'data' => $medicines]);
    }

    public function apiForgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'bail|required|email',
        ]);
        $user = User::where('email', $request->email)->first();
        $setting = Setting::first();
        $notification_template = NotificationTemplate::where('title', 'forgot password')->first();
        if ($user) {
            $password = rand(100000, 999999);
            $user->password = Hash::make($password);
            $user->save();

            $placeholders = [
                '{{user_name}}' => $user->name,
                '{{password}}' => $password,
                '{{app_name}}' => $setting->business_name,
            ];

            $msg1 = $notification_template->msg_content;
            $mail1 = $notification_template->mail_content;

            $placeholder_keys = array_keys($placeholders);
            $placeholder_values = array_values($placeholders);
            $mail1 = str_ireplace($placeholder_keys, $placeholder_values, $mail1);
            $msg1 = str_ireplace($placeholder_keys, $placeholder_values, $msg1);

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
                Mail::to($user->email)->send(new SendMail($mail1, $notification_template->subject));
            } catch (\Exception $e) {
                info($e);
            }

            return response(['success' => true, 'msg' => 'Password sent into your mail']);
        } else {
            return response(['success' => false, 'msg' => 'User not found..!!']);
        }
    }

    public function apiCancelAppointment(Request $request)
    {
        $data = $request->all();
        $appointment = Appointment::find($data['appointment_id']);
        if ($appointment) {
            $appointment->appointment_status = 'cancel';
            $appointment->cancel_by = 'user';
            $appointment->cancel_reason = $data['cancel_reason'];
            $appointment->save();
            $doctor = User::where('id', Doctor::where('id', $appointment->doctor_id)->value('user_id'))->first();
            $status = 'canceled';
            (new CustomController)->statusChangeNotification($doctor, $appointment, $status, 'doctor');
            (new CustomController)->cancelScheduledNotification($appointment->scheduled_notification_id_patient, $appointment->scheduled_notification_id_doctor);

            return response(['success' => true, 'msg' => 'appointment cancel']);
        } else {
            return response(['success' => false, 'msg' => 'appointment not found']);
        }
    }

    public function apiAddAddress(Request $request)
    {
        $request->validate([
            'address' => 'bail|required',
            'lat' => 'bail|required',
            'lang' => 'bail|required',
        ]);
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        UserAddress::create($data);

        return response(['success' => true, 'msg' => 'Address Added..!!']);
    }

    public function apiShowAddress()
    {
        $addresses = UserAddress::where('user_id', auth()->user()->id)->get(['id', 'address', 'lat', 'lang', 'label']);

        return response(['success' => true, 'data' => $addresses, 'msg' => 'User Address !!']);
    }

    public function apiDeleteAddress($id)
    {
        $address = UserAddress::find($id);
        $address->delete();

        return response(['success' => true, 'msg' => 'Address deleted... !!']);
    }

    public function apiAddReview(Request $request)
    {
        $request->validate([
            'review' => 'bail|required',
            'rate' => 'bail|required',
            'appointment_id' => 'bail|required',
        ]);
        $data = $request->all();
        if (Review::where([['appointment_id', $data['appointment_id'], ['user_id', auth()->user()->id]]])->exists() != true) {
            if (Appointment::find($data['appointment_id'])) {
                $data['doctor_id'] = Appointment::find($data['appointment_id'])->doctor_id;
                $data['user_id'] = auth()->user()->id;
                Review::create($data);

                return response(['success' => true, 'data' => __('Thank You For This Review.!!')]);
            } else {
                return response(['success' => false, 'data' => __('Appointment Not Found.!!')]);
            }
        } else {
            return response(['success' => false, 'data' => __('Review Already Added.!!')]);
        }
    }

    public function apiSingleMedicineDetails($purchase_medicine_id)
    {
        $purchase_medicine = PurchaseMedicine::find($purchase_medicine_id);

        return response(['success' => true, 'data' => $purchase_medicine]);
    }

    public function apiCheckCoupon(Request $request)
    {
        $request->validate([
            'offer_code' => 'bail|required',
            'date' => 'bail|required',
            'from' => 'bail|required|in:appointment,medicine',
            'doctor_id' => 'bail|required_if:from,appointment',
        ]);
        $data = $request->all();
        $coupen = Offer::where([['offer_code', $request->offer_code], ['status', 1]])->whereColumn('max_use', '>', 'use_count')->first();
        if ($coupen) {
            $users = explode(',', $coupen->user_id);
            $doctors = explode(',', $coupen->doctor_id);
            if (($key = array_search(auth()->user()->id, $users)) !== false) {
                if ($request->from == 'appointment') {
                    if (($key = array_search($request->doctor_id, $doctors)) !== false) {
                        $exploded_date = explode(' - ', $coupen->start_end_date);
                        $currentDate = date('Y-m-d', strtotime($data['date']));
                        if (($currentDate >= $exploded_date[0]) && ($currentDate <= $exploded_date[1])) {
                            $promo = Offer::where('offer_code', $request->offer_code)->first(['id', 'name', 'offer_code', 'discount', 'discount_type', 'is_flat', 'flatDiscount', 'min_discount'])->makeHidden(['fullImage']);

                            return response(['success' => true, 'data' => $promo]);
                        } else {
                            return response(['success' => false, 'msg' => 'Coupon Is Expire.']);
                        }
                    } else {
                        return response(['success' => false, 'msg' => __('Coupon is not valid for this doctor.!')]);
                    }
                } else {
                    $exploded_date = explode(' - ', $coupen->start_end_date);
                    $currentDate = date('Y-m-d', strtotime($data['date']));
                    if (($currentDate >= $exploded_date[0]) && ($currentDate <= $exploded_date[1])) {
                        $promo = Offer::where('offer_code', $request->offer_code)->first(['id', 'name', 'offer_code', 'discount', 'discount_type', 'is_flat', 'flatDiscount', 'min_discount'])->makeHidden(['fullImage']);

                        return response(['success' => true, 'data' => $promo]);
                    } else {
                        return response(['success' => false, 'msg' => 'Coupon Is Expire.']);
                    }
                }
            } else {
                return response(['success' => false, 'msg' => __('Coupon is not valid for this user.!')]);
            }
        } else {
            return response(['success' => false, 'msg' => __('Coupon code is invalid...!!')]);
        }
    }

    public function apiUserNotification()
    {
        $data = Notification::with('doctor:id,name,image')->where([['user_id', auth()->user()->id], ['user_type', 'user']])->get();

        return response(['success' => false, 'data' => $data]);
    }

    public function apiAddBookmark($doctor_id)
    {
        $user_id = auth()->user()->id;
        $faviroute = Faviroute::where([['user_id', $user_id], ['doctor_id', $doctor_id]])->first();
        if (! $faviroute) {
            $data = [];
            $data['user_id'] = $user_id;
            $data['doctor_id'] = $doctor_id;
            Faviroute::create($data);

            return response(['success' => true, 'msg' => __('Added to favorites..!!')]);
        } else {
            $faviroute->delete();

            return response(['success' => true, 'msg' => __('Removed from favorites..!!')]);
        }
    }

    public function apiBanner()
    {
        $data = Banner::get();

        return response(['success' => true, 'data' => $data]);
    }

    public function apiFaviroute()
    {
        $favourites = Faviroute::where('user_id', auth()->user()->id)->get(['doctor_id']);
        $doctors = Doctor::with(['treatment:id,name'])->whereIn('id', $favourites)->get(['id', 'image', 'name', 'treatment_id'])->makeHidden(['created_at', 'updated_at', 'rate', 'review']);

        return response(['success' => true, 'data' => $doctors]);
    }

    public function checkFavourite($doctor_id)
    {
        if (auth('api')->user() != null) {
            if (Faviroute::where([['user_id', auth('api')->user()->id], ['doctor_id', $doctor_id]])->first()) {
                return true;
            }

            return false;
        }

        return false;
    }

    public function apiGenerateToken(Request $request)
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

            $doctor = Doctor::find($request->to_id);
            $doctor_user = User::find($doctor->user_id);
            $token = \RtcTokenBuilder::buildTokenWithUid($appID, $appCertificate, $channelName, $uid, $role, $privilegeExpiredTs);
            User::whereIn('id', [auth()->id(), $doctor_user->id])->update(['channel_name' => $cn, 'agora_token' => $token]);
            $this->oneSignalNoti($doctor_user->device_token, auth()->user()->name, $token, $cn, $appID);

            return response()->json(['msg' => null, 'data' => ['agora_token' => $token, 'cn' => $cn, 'appId' => $appID], 'success' => true], 200);
        }

        return response()->json(['success' => false, 'msg' => 'Token And ID Not Available'], 200);
    }

    public function oneSignalNoti($userid, $sub, $agoraToken, $channelId, $appId)
    {
        try {
            $settings = Setting::select('doctor_app_id', 'doctor_api_key', 'doctor_auth_key')->first();
            Config::set('onesignal.app_id', $settings->doctor_app_id);
            Config::set('onesignal.rest_api_key', $settings->doctor_api_key);
            Config::set('onesignal.user_auth_key', $settings->doctor_auth_key);
            $data = [
                'name' => $sub,
                'id' => auth()->user()->id,
                'channelId' => $channelId,
                'appId' => $appId,
                'agoraToken' => $agoraToken,
            ];
            info($data);

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

    public function apiVideoCallHistory()
    {
        $user = auth()->user();
        if (! $user->hasAnyRole(Role::all())) {
            $history = VideoCallHistory::with(['doctor:id,name,image', 'user:id,name,image'])->where('user_id', auth()->user()->id)->get()->makeHidden(['created_at', 'updated_at']);
        } else {
            $doctor = Doctor::where('user_id', $user->id)->first();
            $history = VideoCallHistory::with(['doctor:id,name,image', 'user:id,name,image'])->where('doctor_id', $doctor->id)->get()->makeHidden(['created_at', 'updated_at']);
        }

        return response(['success' => true, 'data' => $history]);
    }

    public function apiAddHistory(Request $request)
    {
        $request->validate([
            'doctor_id' => 'bail|required',
            'date' => 'bail|required',
            'start_time' => 'bail|required',
            'duration' => 'bail|required',
        ]);
        $data = $request->all();
        $doctor = Doctor::where('user_id', auth()->user()->id)->first();
        $data['doctor_id'] = $doctor->id;
        VideoCallHistory::create($data);

        return response(['success' => true]);
    }

    public function getNearDoctor($doctor, $lat, $lang)
    {
        $doctors = [];
        $radius = Setting::first()->radius;
        $hospitals = Hospital::whereStatus(1)->GetByDistance($lat, $lang, $radius)->pluck('id')->toArray();
        foreach ($doctor as $d) {
            $h = explode(',', $d->hospital_id);
            if (! empty(array_intersect($hospitals, $h))) {
                $hss = array_intersect($hospitals, $h);
                $array = [];
                foreach ($hss as $hospital) {
                    $h = Hospital::find($hospital);
                    $temp['hospital_distance'] = number_format($this->distance($h['lat'], $h['lng'], $lat, $lang), 2);
                    $temp['hospital_name'] = $h->name;
                    array_push($array, $temp);
                    $d->hospital_id = $array;
                }
                array_push($doctors, $d);
            }
        }

        return $doctors;
    }

    public function deleteAccount()
    {
        $user = auth()->user();
        $booking = Appointment::where('user_id', $user->id)->where('payment_status', 0)->first();
        if (isset($booking) && $user->email == 'demouser@saasmonks.in') {
            return response()->json(['success' => false, 'message' => 'Account Cant\'t Delete']);
        } else {
            $timezone = Setting::first()->timezone;
            $user->name = 'Deleted User';
            $user->email = ' deleteduser_'.Carbon::now($timezone)->format('Y_m_d_H_i_s').'@saasmonks.in';
            $user->phone = '0000000000';
            $user->verify = 0;
            $user->status = 0;
            $user->save();
            Auth::user()->tokens->each(function ($token, $key) {
                $token->delete();
            });
        }

        return response()->json(['success' => true, 'message' => 'Account Delete Successfully!']);
    }

    public function insurers()
    {
        try {
            $insurers = Insurer::where('status', 1)->get()->makeHidden(['created_at', 'updated_at']);

            return response()->json(['success' => true, 'data' => $insurers]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }

    public function apiSendMessageToDoctorNotificationTrigger(Request $request)
    {
        $request->validate([
            'content' => 'bail|required',
            'to_device_token' => 'bail|required',
        ]);

        if ($request->to_device_token == 'N_A' || $request->to_device_token == '') {
            return; // response()->json(['success' => false, 'message' => 'Device token not found']);
        }

        $setting = Setting::first();
        if ($setting->doctor_notification == 1) {

            $receiver_user = User::where('device_token', $request->to_device_token)->first();
            if (! $receiver_user) {
                return; // response()->json(['success' => false, 'message' => 'Receiver user not found']);
            }

            try {
                $client = new OneSignalClient(
                    $setting->doctor_app_id,
                    $setting->doctor_api_key,
                    $setting->doctor_auth_key
                );

                $client->async()->sendNotificationCustom([
                    'headings' => ['en' => auth()->user()->name],
                    'contents' => ['en' => $request->content],
                    'include_player_ids' => [$receiver_user->device_token],
                    'data' => [
                        'screen' => 'screen',
                        'userId' => auth()->user()->id,
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
