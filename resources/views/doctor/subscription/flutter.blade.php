<html>
    <body onload="document.forms['member_signup'].submit()">
        <form method="POST" name="member_signup" action="https://checkout.flutterwave.com/v3/hosted/pay">
            <input type="hidden" name="public_key" value="{{App\Models\Setting::find(1)->flutterwave_key}}" />
            <input type="hidden" name="customer[email]" value="{{ $subscription->customer->email }}" />
            <input type="hidden" name="customer[phone_number]" value="{{ $subscription->customer->phone }}" />
            <input type="hidden" name="customer[name]" value="{{ $subscription->customer->name }}" />
            <input type="hidden" name="tx_ref" value="{{ $subscription->subscription_id }}" />
            <input type="hidden" name="amount" step="any" value="{{ $subscription->amount }}" />
            <input type="hidden" name="currency" value="{{App\Models\Setting::find(1)->currency_code}}" />
            <input type="hidden" name="meta[token]" value="20" />
            <input type="hidden" name="redirect_url" value="{{ url('subscription_flutter_verify/'.$subscription->id) }}" />
        </form>
    </body>
</html>
