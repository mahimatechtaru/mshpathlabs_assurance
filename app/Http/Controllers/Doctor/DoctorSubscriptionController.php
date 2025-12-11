<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorSubscription;
use App\Models\Setting;
use App\Models\Subscription;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Stripe\StripeClient;
use Symfony\Component\HttpFoundation\Response;

class DoctorSubscriptionController extends Controller
{
    public function doctor_subscription()
    {
        abort_if(Gate::denies('doctor_subscription'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $subscriptions = Subscription::orderBy('id', 'DESC')->get();
        $currency = Setting::first()->currency_symbol;
        $doctor = Doctor::where('user_id', auth()->user()->id)->first();
        $purchase = DoctorSubscription::where([['doctor_id', $doctor->id], ['status', 1]])->first();

        return view('doctor.subscription.subscription', compact('subscriptions', 'currency', 'purchase'));
    }

    public function subscription_purchase($subscription_id)
    {
        abort_if(Gate::denies('doctor_subscription_purchase'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $subscription = Subscription::find($subscription_id);
        $setting = Setting::first();

        return view('doctor.subscription.purchase_subscription', compact('subscription', 'setting'));
    }

    public function purchase(Request $request)
    {
        $data = $request->all();
        $doctor = Doctor::where('user_id', auth()->user()->id)->first();
        $doctor->update(['payment_status' => 1]);
        DoctorSubscription::where([['status', 1], ['doctor_id', $doctor->id]])->update(['status' => 0]);
        $data['doctor_id'] = $doctor->id;
        $data['start_date'] = Carbon::now(env('timezone'))->format('Y-m-d');
        $data['end_date'] = Carbon::now(env('timezone'))->addMonths($data['duration'])->format('Y-m-d');
        $data['status'] = 1;
        $subscription = DoctorSubscription::create($data);
        if ($subscription->payment_status == 1) {
            $doctor->subscription_status = 1;
            $doctor->save();
        }
        if ($subscription->payment_type == 'FLUTTERWAVE') {
            return response(['success' => true, 'url' => url('subscription_flutter/'.$subscription->id)]);
        }

        return response(['success' => true]);
    }

    public function subscription_flutter($subscription_id)
    {
        $subscription = DoctorSubscription::find($subscription_id);
        $subscription->customer = auth()->user();

        return view('doctor.subscription.flutter', compact('subscription'));
    }

    public function subscription_flutter_verify(Request $request, $subscription_id)
    {
        $subscription = DoctorSubscription::find($subscription_id);
        $id = $request->input('transaction_id');
        if ($request->input('status') == 'successful') {
            $doctor = Doctor::where('user_id', auth()->user()->id)->first();
            $doctor->subscription_status = 1;
            $doctor->save();
            $subscription->payment_token = $id;
            $subscription->payment_status = 1;
            $subscription->save();

            return redirect('/subscription');
        } else {
            return redirect('/subscription');
        }
    }

    public function stripePayment(Request $request)
    {
        $data = $request->all();
        $currency = Setting::find(1)->currency_code;
        $amount = $currency == 'USD' || $currency == 'EUR' ? $data['amount'] * 100 : $data['amount'];
        $paymentSetting = Setting::find(1);
        $stripe_sk = $paymentSetting->stripe_secret_key;
        $stripe = new StripeClient($stripe_sk);
        $charge = $stripe->charges->create([
            'amount' => $amount,
            'currency' => $currency,
            'source' => $request->stripeToken,
        ]);

        return response(['success' => true, 'data' => $charge->id]);
    }
}
