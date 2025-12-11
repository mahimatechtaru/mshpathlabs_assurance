<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorSubscription;
use App\Models\Setting;
use App\Models\Subscription;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('subscription_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $subscriptions = Subscription::orderBy('id', 'DESC')->get();
        $purchase = '';
        $currency = Setting::first()->currency_symbol;
        if (auth()->user()->hasRole('doctor')) {
            $doctor = Doctor::where('user_id', auth()->user()->id)->first();
            $purchase = DoctorSubscription::where([['doctor_id', $doctor->id], ['status', 1]])->first();
        }

        return view('superAdmin.subscription.subscription', compact('subscriptions', 'currency', 'purchase'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('subscription_add'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('superAdmin.subscription.create_subscription');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required|max:255|unique:subscription',
            'total_appointment' => 'bail|required|numeric',
        ]);
        $data = $request->all();
        $plan = [];
        for ($i = 0; $i < count($data['month']); $i++) {
            $temp['month'] = $data['month'][$i];
            $temp['price'] = $data['price'][$i];
            array_push($plan, $temp);
        }
        $data['plan'] = json_encode($plan);
        Subscription::create($data);

        return redirect('subscription')->withStatus(__('subscription created successfully..!!'));
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
        abort_if(Gate::denies('subscription_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $subscription = Subscription::find($id);

        return view('superAdmin.subscription.edit_subscription', compact('subscription'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'bail|required|max:255|unique:subscription,name,'.$id.',id',
            'total_appointment' => 'bail|required|numeric',
        ]);
        $subscription = Subscription::find($id);
        $data = $request->all();
        $plan = [];
        for ($i = 0; $i < count($data['month']); $i++) {
            $temp['month'] = $data['month'][$i];
            $temp['price'] = $data['price'][$i];
            array_push($plan, $temp);
        }
        $data['plan'] = json_encode($plan);
        $subscription->update($data);

        return redirect('subscription')->withStatus(__('subscription updated successfully..!!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = Subscription::find($id);
        $id->delete();

        return response(['success' => true]);
    }

    public function subscription_history()
    {
        abort_if(Gate::denies('subscription_history'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $currency = Setting::first()->currency_symbol;
        $subscriptions = DoctorSubscription::with(['Subscription', 'doctor'])->orderBy('id', 'DESC')->get();
        if (auth()->user()->hasRole('doctor')) {
            $doctor = Doctor::where('user_id', auth()->user()->id)->first();
            $subscriptions = DoctorSubscription::with(['Subscription', 'doctor'])->where('doctor_id', $doctor->id)->orderBy('id', 'DESC')->get();
        }

        return view('superAdmin.subscription.subscription_history', compact('subscriptions', 'currency'));
    }

    public function changePaymentStatus($id)
    {
        $subscription = DoctorSubscription::find($id);
        $subscription->update(['payment_status' => 1]);
        $doctor = Doctor::find($subscription->doctor_id);
        $doctor->update(['subscription_status' => 1]);

        return response(['success' => true]);
    }
}
