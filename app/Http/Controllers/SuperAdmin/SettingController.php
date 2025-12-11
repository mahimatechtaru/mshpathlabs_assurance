<?php

namespace App\Http\Controllers\SuperAdmin;

use App;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Language;
use App\Models\Setting;
use App\Models\Timezone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use LicenseBoxExternalAPI;
use Symfony\Component\HttpFoundation\Response;

class SettingController extends Controller
{
    public function setting()
    {
        abort_if(Gate::denies('superadmin_setting'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $setting = Setting::first();
        $timezones = Timezone::get();
        $currencies = Currency::get();
        $languages = Language::whereStatus(1)->get();

        return view('superAdmin.setting.setting', compact('setting', 'timezones', 'currencies', 'languages'));
    }

    public function update_general_setting(Request $request)
    {
        abort_if(Gate::denies('superadmin_setting'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate(
            [
                'email' => 'bail|email',
                'contact' => 'bail|digits_between:6,12',
                'company_white_logo' => 'bail|max:1000',
                'company_logo' => 'bail|mimes:jpeg,png,jpg|max:1000',
                'company_favicon' => 'bail|mimes:jpeg,png,jpg|max:1000',
            ],
            [
                'company_white_logo.max' => 'The Image May Not Be Greater Than 1 MegaBytes.',
            ],
            [
                'company_logo.max' => 'The Image May Not Be Greater Than 1 MegaBytes.',
            ],
            [
                'company_favicon.max' => 'The Image May Not Be Greater Than 1 MegaBytes.',
            ],
        );
        $setting = Setting::first();
        $data = $request->all();
        $currency = Currency::where('id', $data['currency_code'])->first();
        $data['currency_symbol'] = $currency->symbol;
        $data['currency_id'] = $data['currency_code'];
        $data['currency_code'] = $currency->code;
        // $data['currency_symbol'] = Currency::where('code',$data['currency_code'])->first()->symbol;
        if ($request->hasFile('company_white_logo')) {
            (new CustomController)->deleteFile($setting->company_white_logo);
            $data['company_white_logo'] = (new CustomController)->imageUpload($request->company_white_logo);
        }
        if ($request->hasFile('company_logo')) {
            (new CustomController)->deleteFile($setting->company_logo);
            $data['company_logo'] = (new CustomController)->imageUpload($request->company_logo);
        }
        if ($request->hasFile('company_favicon')) {
            (new CustomController)->deleteFile($setting->company_favicon);
            $data['company_favicon'] = (new CustomController)->imageUpload($request->company_favicon);
        }
        $data['cancel_reason'] = json_encode($data['cancel_reason']);
        $setting->update($data);
        $this->changeLanguage();
        $timezone['timezone'] = $data['timezone'];
        $success = (new CustomController)->updateENV($timezone);
        if ($success) {
            return redirect()->back()->withStatus(__('General Setting updated successfully..!!'));
        } else {
            return redirect()->back()->with('error_msg', __('Env file has not enough permission.'));
        }
    }

    public function changeLanguage()
    {
        abort_if(Gate::denies('superadmin_setting'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $language = Setting::first()->language;
        App::setLocale($language);
        session()->put('locale', $language);
        $direction = Language::where('name', $language)->first()->direction;
        session()->put('direction', $direction);

        return true;
    }

    public function update_payment_setting(Request $request)
    {
        abort_if(Gate::denies('superadmin_setting'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'stripe_public_key' => 'bail|required_if:stripe,1',
            'stripe_secret_key' => 'bail|required_if:stripe,1',
            'paypal_secret_key' => 'bail|required_if:paypal,1',
            'paypal_client_id' => 'bail|required_if:paypal,1',
            'razor_key' => 'bail|required_if:razor,1',
            'paystack_public_key' => 'bail|required_if:paystack,1',
            'flutterwave_key' => 'bail|required_if:flutterwave,1',
        ]);
        $data = $request->all();
        $data['stripe'] = $request->has('stripe') ? 1 : 0;
        $data['cod'] = $request->has('cod') ? 1 : 0;
        $data['paypal'] = $request->has('paypal') ? 1 : 0;
        $data['razor'] = $request->has('razor') ? 1 : 0;
        $data['flutterwave'] = $request->has('flutterwave') ? 1 : 0;
        $data['paystack'] = $request->has('paystack') ? 1 : 0;
        $id = Setting::first();
        $id->update($data);

        return redirect()->back()->withStatus(__('Payment Setting updated successfully..!!'));
    }

    public function update_verification_setting(Request $request)
    {
        abort_if(Gate::denies('superadmin_setting'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            // 'verification' => 'bail|required|in:0,1',
            'verification_method' => 'bail|required_if:verification,1|in:email,sms',
            'twilio_auth_token' => 'bail|required_if:using_msg,1',
            'twilio_acc_id' => 'bail|required_if:using_msg,1',
            'twilio_phone_no' => 'bail|required_if:using_msg,1',
            'mail_mailer' => 'bail|required_if:using_mail,1',
            'mail_host' => 'bail|required_if:using_mail,1',
            'mail_port' => 'bail|required_if:using_mail,1',
            'mail_username' => 'bail|required_if:using_mail,1',
            'mail_password' => 'bail|required_if:using_mail,1',
            'mail_encryption' => 'bail|required_if:using_mail,1',
            'mail_from_address' => 'bail|required_if:using_mail,1',
            'mail_from_name' => 'bail|required_if:using_mail,1',
        ],
            [
                'verification_method.required_if' => 'Choose either email or sms verification method',
            ]
        );
        $data = $request->all();

        if (isset($data['verification']) && $data['verification_method'] == 'email') {
            $data['using_mail'] = 1;
            $data['using_msg'] = 0;
        } elseif (isset($data['verification']) && $data['verification_method'] == 'sms') {
            $data['using_mail'] = 0;
            $data['using_msg'] = 1;
        } else {
            $data['using_mail'] = 0;
            $data['using_msg'] = 0;
            $data['verification'] = 0;
        }

        Setting::find(1)->update($data);

        return redirect()->back()->with('status', __('verification Setting updated successfully..!!'));
    }

    public function update_content(Request $request)
    {
        abort_if(Gate::denies('superadmin_setting'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'popup_target_url' => 'bail|required',
        ]);
        $data = $request->all();
        $setting = Setting::first();
        if ($request->hasFile('banner_image')) {
            (new CustomController)->deleteFile($setting->banner_image);
            $data['banner_image'] = (new CustomController)->imageUpload($request->banner_image);
        }
        if ($request->hasFile('landing_popup_image')) {
            (new CustomController)->deleteFile($setting->landing_popup_image);
            $data['landing_popup_image'] = (new CustomController)->imageUpload($request->landing_popup_image);
        }
        $setting->landing_popup_switch = $request->has('landing_popup_switch') ? 1 : 0;
        $setting->update($data);

        return redirect()->back()->withStatus(__('Website Setting updated successfully.!'));
    }

    public function update_notification(Request $request)
    {
        abort_if(Gate::denies('superadmin_setting'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'patient_app_id' => 'bail|required_if:patient_notification,1',
            'patient_auth_key' => 'bail|required_if:patient_notification,1',
            'patient_api_key' => 'bail|required_if:patient_notification,1',
            'doctor_app_id' => 'bail|required_if:doctor_notification,1',
            'doctor_auth_key' => 'bail|required_if:doctor_notification,1',
            'doctor_api_key' => 'bail|required_if:doctor_notification,1',
        ]);
        $data = $request->all();
        $data['patient_mail'] = $request->has('patient_mail') ? 1 : 0;
        $data['doctor_mail'] = $request->has('doctor_mail') ? 1 : 0;
        $data['doctor_notification'] = $request->has('doctor_notification') ? 1 : 0;
        $data['patient_notification'] = $request->has('patient_notification') ? 1 : 0;
        Setting::first()->update($data);

        return redirect()->back()->withStatus(__('Notification setting updated successfully..!!'));
    }

    public function update_licence_setting(Request $request)
    {
        abort_if(Gate::denies('superadmin_setting'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'license_code' => 'required',
            'client_name' => 'required',
        ]);
        $api = new LicenseBoxExternalAPI;
        $result = $api->activate_license($request->license_code, $request->client_name);
        if ($result['status'] == true) {
            $id = Setting::find(1);
            $data = $request->all();
            $data['license_verify'] = 1;
            $id->update($data);

            return redirect('/login');
        } else {
            return redirect()->back()->with('error_msg', $result['message']);
        }

        return redirect('admin/setting');
    }

    public function update_static_page(Request $request)
    {
        abort_if(Gate::denies('superadmin_setting'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        Setting::first()->update($request->all());

        return redirect()->back()->withStatus(__('Setting updated successfully..!!'));
    }

    public function update_video_call_setting(Request $request)
    {
        abort_if(Gate::denies('superadmin_setting'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        Setting::first()->update($request->all());

        return redirect()->back()->withStatus(__('Setting updated successfully..!!'));
    }

    public function update_zoom_setting(Request $request)
    {
        abort_if(Gate::denies('superadmin_setting'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'zoom_client_id' => 'required_if:zoom_switch,1',
            'zoom_client_secret' => 'required_if:zoom_switch,1',
            'zoom_redirect_url' => 'required_if:zoom_switch,1',
        ], [
            'zoom_client_id.required_if' => 'The Zoom Client ID field is required when Zoom is enabled.',
            'zoom_client_secret.required_if' => 'The Zoom Client Secret field is required when Zoom is enabled.',
            'zoom_redirect_url.required_if' => 'The Zoom Redirect URL field is required when Zoom is enabled.',
        ]);
        $data = $request->all();
        $data['zoom_switch'] = $request->has('zoom_switch') ? 1 : 0;
        Setting::first()->update($data);

        return redirect()->back()->withStatus(__('Zoom settings updated successfully..!!'));
    }
}
