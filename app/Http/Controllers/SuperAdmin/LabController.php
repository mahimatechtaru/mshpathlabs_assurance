<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use App\Models\Country;
use App\Models\Lab;
use App\Models\LabWorkHours;
use App\Models\Report;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class LabController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('lab_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $labs = Lab::with('user')->orderBy('id', 'DESC')->get();
        $center_coords = Setting::select('lat', 'lang')->first();

        return view('superAdmin.lab.lab', compact('labs', 'center_coords'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('lab_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $countries = Country::get();
        $setting = Setting::first();

        return view('superAdmin.lab.create_lab', compact('countries', 'setting'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required',
            'phone_code' => 'bail|required',
            'phone' => 'bail|required|digits_between:6,12',
            'address' => 'bail|required',
            'start_time' => 'bail|required',
            'end_time' => 'bail|required',
            'email' => 'bail|required|email|unique:users',
            'commission' => 'bail|required',
            'image' => 'bail|mimes:jpeg,png,jpg|max:1000',

        ]);
        $data = $request->all();
        $setting = Setting::first();
        $password = mt_rand(100000, 999999);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($password),
            'verify' => 1,
            'phone' => $data['phone'],
            'phone_code' => $data['phone_code'],
            'image' => 'defaultUser.png',
        ]);

        $message1 = 'Dear Pathologist your password is : '.$password;
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
            Mail::to($user->email)->send(new SendMail($message1, 'Pathologist Password'));
        } catch (\Exception $e) {
            info($e);
        }
        $user->assignRole('laboratory');
        if ($request->hasFile('image')) {
            $data['image'] = (new CustomController)->imageUpload($request->image);
        } else {
            $data['image'] = 'defaultUser.png';
        }
        $data['start_time'] = strtolower(Carbon::parse($data['start_time'])->format('h:i a'));
        $data['end_time'] = strtolower(Carbon::parse($data['end_time'])->format('h:i a'));
        $data['user_id'] = $user->id;
        $data['status'] = 1;
        $lab = Lab::create($data);
        $start_time = strtolower($lab->start_time);
        $end_time = strtolower($lab->end_time);
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        for ($i = 0; $i < count($days); $i++) {
            $master = [];
            $temp2['start_time'] = $start_time;
            $temp2['end_time'] = $end_time;
            array_push($master, $temp2);
            $work_time['lab_id'] = $lab->id;
            $work_time['period_list'] = json_encode($master);
            $work_time['day_index'] = $days[$i];
            $work_time['status'] = 1;
            LabWorkHours::create($work_time);
        }

        return redirect('/laboratory')->withStatus(__('Lab created successfully.!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('lab_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $lab = Lab::with('user')->find($id);
        $lab['start_time'] = strtolower(Carbon::parse($lab['start_time'])->format('H:i'));
        $lab['end_time'] = strtolower(Carbon::parse($lab['end_time'])->format('H:i'));
        $countries = Country::get();

        return view('superAdmin.lab.edit_lab', compact('countries', 'lab'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_if(Gate::denies('lab_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'name' => 'bail|required',
            'address' => 'bail|required',
            'start_time' => 'bail|required',
            'end_time' => 'bail|required',
            'image' => 'bail|mimes:jpeg,png,jpg|max:1000',

        ]);
        $data = $request->all();
        $lab = Lab::find($id);

        if ($request->hasFile('image')) {
            (new CustomController)->deleteFile($lab->image);
            $data['image'] = (new CustomController)->imageUpload($request->image);
        }
        $data['start_time'] = strtolower(Carbon::parse($data['start_time'])->format('h:i a'));
        $data['end_time'] = strtolower(Carbon::parse($data['end_time'])->format('h:i a'));
        $lab->update($data);
        if (auth()->user()->hasRole('laboratory')) {
            return redirect()->back()->withStatus(__('Laboratory Profile updated successfully.!'));
        }

        return redirect('/laboratory')->withStatus(__('Laboratory updated successfully.!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('lab_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $lab = Lab::find($id);
        $user = User::find($lab->user_id);
        $user->removeRole('laboratory');
        $user->delete();
        (new CustomController)->deleteFile($lab->image);
        $lab->delete();

        return ['success' => true];
    }

    public function change_status(Request $request)
    {
        abort_if(Gate::denies('lab_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $lab = Lab::find($request->id);
        $data['status'] = $lab->status == 1 ? 0 : 1;
        $lab->update($data);

        return response(['success' => true]);
    }

    public function test_reports()
    {
        abort_if(Gate::denies('test_report'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $test_reports = Report::orderBy('id', 'DESC');
        $currency = Setting::first()->currency_symbol;
        if (auth()->user()->hasRole('laboratory')) {
            $lab = Lab::where('user_id', auth()->user()->id)->first();
            $test_reports = $test_reports->where('lab_id', $lab->id)->get();
        } else {
            $test_reports = $test_reports->get();
        }

        return view('superAdmin.lab.test_report', compact('test_reports', 'currency'));
    }

    public function upload_report(Request $request)
    {
        abort_if(Gate::denies('test_report'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $report = Report::find($request->report_id);
        if ($report) {
            $image = $request->upload_report;
            $file = $image;
            $fileName = uniqid().'.'.$image->getClientOriginalExtension();
            $path = public_path().'/report_prescription/report';
            $file->move($path, $fileName);
            $report['upload_report'] = $fileName;
            $report->save();
        }

        return redirect()->back()->withStatus(__('Report Uploaded Successfully'));
    }
}
