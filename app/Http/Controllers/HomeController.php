<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SuperAdmin\CustomController;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\User;
use Carbon\Carbon;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        abort_if(Gate::denies('superadmin_dashboard'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        (new CustomController)->cancel_max_order();
        $orderCharts = $this->orderChart();
        $users = $this->userChart();
        $allUsers = User::doesntHave('roles')->orderBy('id', 'DESC')->get()->take(10);
        $allDoctors = Doctor::with('treatment')->orderBy('id', 'DESC')->get()->take(10);
        $totalDoctors = Doctor::count();
        $totalUsers = User::doesntHave('roles')->count();
        $totalAppointments = Appointment::count();

        return view('home', compact('orderCharts', 'users', 'allUsers', 'allDoctors', 'totalDoctors', 'totalUsers', 'totalAppointments'));
    }

    public function orderChart()
    {
        $masterYear = [];
        $labelsYear = [];

        array_push($masterYear, Appointment::whereMonth('created_at', Carbon::now(env('timezone')))->count());
        for ($i = 1; $i <= 11; $i++) {
            if ($i >= Carbon::now(env('timezone'))->month) {
                array_push($masterYear, Appointment::whereMonth('created_at', Carbon::now(env('timezone'))->subMonths($i))->whereYear('created_at', Carbon::now(env('timezone'))->subYears(1))->count());
            } else {
                array_push($masterYear, Appointment::whereMonth('created_at', Carbon::now(env('timezone'))->subMonths($i))->whereYear('created_at', Carbon::now(env('timezone'))->year)->count());
            }
        }

        array_push($labelsYear, Carbon::now(env('timezone'))->format('M-y'));
        for ($i = 1; $i <= 11; $i++) {
            array_push($labelsYear, Carbon::now(env('timezone'))->subMonths($i)->format('M-y'));
        }

        return ['data' => json_encode($masterYear), 'label' => json_encode($labelsYear)];
    }

    public function userChart()
    {
        $now = Carbon::today();
        $month = [];
        $doctor = [];
        $user = [];
        for ($i = 0; $i < 12; $i++) {
            $d = Doctor::whereMonth('created_at', $now->month)->whereYear('created_at', $now->year)->get();
            $s = User::doesntHave('roles')->whereMonth('created_at', $now->month)->whereYear('created_at', $now->year)->get();
            array_push($month, $now->format('M'));
            array_push($doctor, $d->count());
            array_push($user, $s->count());
            $now = $now->subMonth();
        }

        $master['doctor'] = json_encode($doctor);
        $master['month'] = json_encode($month);
        $master['user'] = json_encode($user);

        return $master;
    }
}
