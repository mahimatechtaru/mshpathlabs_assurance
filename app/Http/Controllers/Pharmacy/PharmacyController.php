<?php

namespace App\Http\Controllers\Pharmacy;

use App;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SuperAdmin\CustomController;
use App\Models\Country;
use App\Models\Language;
use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\PharmacySettle;
use App\Models\PharmacyWorkingHour;
use App\Models\PurchaseMedicine;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PharmacyController extends Controller
{
    public function pharmacyLogin()
    {
        return view('pharmacyAdmin.auth.login');
    }

    public function verify_pharmacy(Request $request)
    {
        $request->validate([
            'email' => 'bail|required|email',
            'password' => 'bail|required|min:6',
        ]);

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $pharmacy = Auth::user()->load('roles');
            if ($pharmacy->hasRole('pharmacy')) {
                if ($pharmacy->verify == 1) {
                    $pharmacy = Pharmacy::where('user_id', auth()->user()->id)->first();
                    if ($pharmacy->status == 1) {
                        return redirect('pharmacy_home');
                    } else {
                        Auth::logout();

                        return redirect()->back()->withErrors('you are disable by admin please contact admin');
                    }
                } else {
                    return redirect('pharmacy/send_otp/'.$pharmacy->id);
                }
            } else {
                Auth::logout();

                return redirect()->back()->withErrors('Only pharmacy can login');
            }
        } else {
            Auth::logout();

            return redirect()->back()->withErrors('your credential does not match our record');
        }
    }

    public function pharmacy_home()
    {
        $pharmacy = Pharmacy::where('user_id', auth()->user()->id)->first();
        $today_sells = PharmacySettle::where('pharmacy_id', $pharmacy->id)->whereDate('created_at', Carbon::now(env('timezone')))->sum('pharmacy_amount');
        $total_medicines = Medicine::where('pharmacy_id', $pharmacy->id)->count();
        $currency = Setting::first()->currency_symbol;
        $revenueCharts = $this->revenueChart();

        return view('pharmacyAdmin.home', compact('today_sells', 'total_medicines', 'currency', 'revenueCharts'));
    }

    public function revenueChart()
    {
        $masterYear = [];
        $labelsYear = [];

        array_push($masterYear, PharmacySettle::whereMonth('created_at', Carbon::now(env('timezone')))->sum('pharmacy_amount'));
        for ($i = 1; $i <= 11; $i++) {
            if ($i >= Carbon::now(env('timezone'))->month) {
                array_push($masterYear, PharmacySettle::whereMonth('created_at', Carbon::now(env('timezone'))->subMonths($i))->whereYear('created_at', Carbon::now(env('timezone'))->subYears(1))->sum('pharmacy_amount'));
            } else {
                array_push($masterYear, PharmacySettle::whereMonth('created_at', Carbon::now(env('timezone'))->subMonths($i))->whereYear('created_at', Carbon::now(env('timezone'))->year)->sum('pharmacy_amount'));
            }
        }

        array_push($labelsYear, Carbon::now(env('timezone'))->format('M-y'));
        for ($i = 1; $i <= 11; $i++) {
            array_push($labelsYear, Carbon::now(env('timezone'))->subMonths($i)->format('M-y'));
        }

        return ['data' => json_encode($masterYear), 'label' => json_encode($labelsYear)];
    }

    public function pharmacy_signUp()
    {
        $countries = Country::get();

        return view('pharmacyAdmin.auth.signup', compact('countries'));
    }

    public function pharmacy_register(Request $request)
    {
        $request->validate([
            'name' => 'bail|required',
            'phone' => 'bail|required|digits_between:6,12',
            'email' => 'bail|required|email|unique:users',
            'address' => 'bail|required',
            'password' => 'bail|required|min:6',
        ]);
        $data = $request->all();
        $password = $request->password;
        $setting = Setting::first();
        $verify = $setting->verification == 1 ? 0 : 1;
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($password),
            'verify' => $verify,
            'phone' => $data['phone'],
            'phone_code' => $data['phone_code'],
        ]);
        Auth::loginUsingId($user->id);
        $user->assignRole('pharmacy');
        $data['user_id'] = $user->id;
        $data['start_time'] = strtolower('08:00 am');
        $data['end_time'] = strtolower('08:00 pm');
        $data['image'] = 'defaultUser.png';
        $data['status'] = 1;
        $data['commission_amount'] = $setting->pharmacy_commission;
        $pharmacy = Pharmacy::create($data);
        $start_time = strtolower($pharmacy->start_time);
        $end_time = strtolower($pharmacy->end_time);
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        for ($i = 0; $i < count($days); $i++) {
            $master = [];
            $temp2['start_time'] = $start_time;
            $temp2['end_time'] = $end_time;
            array_push($master, $temp2);
            $work_time['pharmacy_id'] = $pharmacy->id;
            $work_time['period_list'] = json_encode($master);
            $work_time['day_index'] = $days[$i];
            $work_time['status'] = 1;
            PharmacyWorkingHour::create($work_time);
        }
        if ($user->verify == 1) {
            if (Auth::attempt(['email' => $user['email'], 'password' => $request->password])) {
                return redirect('pharmacy_home');
            }
        } else {
            return redirect('pharmacy/send_otp/'.$user->id);
        }
    }

    public function send_otp($user_id)
    {
        $user = User::find($user_id);
        $setting = Setting::first();

        (new CustomController)->sendOtp($user);
        $status = '';
        if ($setting->using_msg == 1 && $setting->using_mail == 1) {
            $status = 'Verification code sent to both email and phone.';
        } elseif ($setting->using_msg == 1) {
            $status = 'Verification code sent to phone.';
        } elseif ($setting->using_mail == 1) {
            $status = 'Verification code sent to email.';
        }

        return view('pharmacyAdmin.auth.send_otp', compact('user'))->with('status', $status);
    }

    public function verify_otp(Request $request)
    {
        $data = $request->all();
        $otp = $data['digit_1'].$data['digit_2'].$data['digit_3'].$data['digit_4'];
        $user = User::find($request->user_id);
        if ($user) {
            if ($user->otp == $otp) {
                $user->verify = 1;
                $user->save();
                if (Auth::loginUsingId($user->id)) {
                    return redirect('pharmacy_home');
                }
            } else {
                return redirect()->back()->with('error', __('otp does not match'));
            }
        } else {
            return redirect()->back()->with('error', __('Oops.user not found.!'));
        }
    }

    public function pharmacy_schedule()
    {
        $pharmacy = Pharmacy::where('user_id', auth()->user()->id)->first();
        $pharmacy->workingHours = PharmacyWorkingHour::where('pharmacy_id', $pharmacy->id)->get();
        $pharmacy->firstHours = PharmacyWorkingHour::where('pharmacy_id', $pharmacy->id)->first();

        // return $pharmacy;
        return view('pharmacyAdmin.pharmacy.schedule', compact('pharmacy'));
    }

    public function display_pharmacy_timeslot($id)
    {
        $work = PharmacyWorkingHour::find($id);

        return response(['success' => true, 'data' => $work]);
    }

    public function edit_pharmacy_timeslot($id)
    {
        $work = PharmacyWorkingHour::find($id);

        return response(['success' => true, 'data' => $work]);
    }

    public function update_pharmacy_timeslot(Request $request)
    {
        $data = $request->all();
        $work = PharmacyWorkingHour::find($request->working_id);
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

    public function pharmacyCommission()
    {
        $pharmacy = Pharmacy::where('user_id', auth()->user()->id)->first();
        $now = Carbon::today();
        $medicines = [];
        $currency = Setting::first()->currency_symbol;
        for ($i = 0; $i < 7; $i++) {
            $appointment = PurchaseMedicine::where('pharmacy_id', $pharmacy->id)->whereDate('created_at', $now)->get();
            $appointment['amount'] = $appointment->sum('amount');
            $appointment['admin_commission'] = $appointment->sum('admin_commission');
            $appointment['pharmacy_commission'] = $appointment->sum('pharmacy_commission');
            $now = $now->subDay();
            $appointment['date'] = $now->toDateString();
            array_push($medicines, $appointment);
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
            $settle = PharmacySettle::where('pharmacy_id', $pharmacy->id)->where('created_at', '>=', $key['start'].' 00.00.00')->where('created_at', '<=', $key['end'].' 23.59.59')->get();
            $value['d_total_task'] = $settle->count();
            $value['admin_earning'] = $settle->sum('admin_amount');
            $value['pharmacy_earning'] = $settle->sum('pharmacy_amount');
            $value['d_total_amount'] = $value['admin_earning'] + $value['pharmacy_earning'];
            $remainingOnline = PharmacySettle::where([['pharmacy_id', $pharmacy->id], ['payment', 0], ['pharmacy_status', 0]])->where('created_at', '>=', $key['start'].' 00.00.00')->where('created_at', '<=', $key['end'].' 23.59.59')->get();
            $remainingOffline = PharmacySettle::where([['pharmacy_id', $pharmacy->id], ['payment', 1], ['pharmacy_status', 0]])->where('created_at', '>=', $key['start'].' 00.00.00')->where('created_at', '<=', $key['end'].' 23.59.59')->get();

            $online = $remainingOnline->sum('pharmacy_amount'); // admin e devana
            $offline = $remainingOffline->sum('admin_amount'); // admin e levana

            $value['duration'] = $key['start'].' - '.$key['end'];
            $value['d_balance'] = $offline - $online; // + hoy to levana - devana
            array_push($settels, $value);
        }

        return view('pharmacyAdmin.commission', compact('pharmacy', 'medicines', 'currency', 'settels'));
    }

    public function purchased_medicines()
    {
        $pharmacy = Pharmacy::where('user_id', auth()->user()->id)->first();
        $medicines = PurchaseMedicine::with('user')->where('pharmacy_id', $pharmacy->id)->get();
        $currency = Setting::first()->currency_symbol;

        return view('pharmacyAdmin.medicine.purchase_medicine', compact('medicines', 'currency'));
    }

    public function pharmacy_profile()
    {
        $pharmacy = Pharmacy::where('user_id', auth()->user()->id)->first();
        $pharmacy['start_time'] = Carbon::parse($pharmacy['start_time'])->format('H:i');
        $pharmacy['end_time'] = Carbon::parse($pharmacy['end_time'])->format('H:i');
        $currency = Setting::first()->currency_symbol;
        $languages = Language::whereStatus(1)->get();

        return view('pharmacyAdmin.pharmacyProfile', compact('pharmacy', 'currency', 'languages'));
    }

    public function update_pharmacy_profile(Request $request)
    {
        $request->validate([
            'name' => 'bail|required',
            'start_time' => 'bail|required',
            'end_time' => 'bail|required|after:start_time',
            'address' => 'bail|required',
            'image' => 'bail|max:1000',
        ],
            [
                'image.max' => 'The Image May Not Be Greater Than 1 MegaBytes.',
            ]);
        $pharmacy = Pharmacy::where('user_id', auth()->user()->id)->first();
        $data = $request->all();
        $data['is_shipping'] = $request->has('is_shipping') ? 1 : 0;
        $delivery = [];
        for ($i = 0; $i < count($data['min_value']); $i++) {
            $temp['min_value'] = $data['min_value'][$i];
            $temp['max_value'] = $data['max_value'][$i];
            $temp['charges'] = $data['charges'][$i];
            array_push($delivery, $temp);
        }
        $data['delivery_charges'] = json_encode($delivery);
        if ($request->hasFile('image')) {
            (new CustomController)->deleteFile($pharmacy->image);
            $data['image'] = (new CustomController)->imageUpload($request->image);
        }
        $data['start_time'] = strtolower(Carbon::parse($data['start_time'])->format('h:i a'));
        $data['end_time'] = strtolower(Carbon::parse($data['end_time'])->format('h:i a'));
        $pharmacy->update($data);
        $this->changeLanguage();

        return redirect('pharmacy_home');
    }

    public function changeLanguage()
    {
        $pharmacy = Pharmacy::where('user_id', auth()->user()->id)->first();
        App::setLocale($pharmacy->language);
        session()->put('locale', $pharmacy->language);
        $direction = Language::where('name', $pharmacy->language)->first()->direction;
        session()->put('direction', $direction);

        return true;
    }

    public function display_purchase_medicine($id)
    {
        $purchase_medicine = PurchaseMedicine::with('address')->find($id);
        $currency = Setting::first()->currency_symbol;
        $phone = User::select('phone_code', 'phone')->find($purchase_medicine->user_id);
        $phone = $phone->phone_code.$phone->phone;

        return response(['success' => true, 'data' => $purchase_medicine, 'currency' => $currency, 'phone' => $phone]);
    }
}
