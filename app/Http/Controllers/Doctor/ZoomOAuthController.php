<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\NotificationTemplate;
use App\Models\Setting;
use App\Models\User;
use App\Models\ZoomOAuth;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ZoomOAuthController extends Controller
{
    public function setupZoomMeeting($appointment_id)
    {
        $appointment = Appointment::find($appointment_id);

        return view('doctor.setting.create_zoom_meeting', compact('appointment'));
    }

    /**
     * Store the Zoom meeting details in the database
     * It needs the appointment_id as a parameter
     * It returns the response from the Zoom API
     */
    public function storeZoomMeeting(Request $request, $appointment_id)
    {
        if (! Auth::user()->zoomOAuth->is_access_token_valid && Auth::user()->zoomOAuth->refresh_token != '') {
            $this->refresh_token();
        }
        $validator = Validator::make($request->all(), [
            'topic' => 'required|string',
            'date' => 'required|date_format:Y-m-d',
            'time' => 'required|date_format:H:i',
            'agenda' => 'string|nullable',
        ]);
        $data = $validator->validated();

        $datetime = $data['date'].' '.$data['time'].':00';
        $start_time = Carbon::createFromFormat('Y-m-d H:i:s', $datetime); // 2024-08-23 17:00:00
        $duration = Auth::user()->doctorProfile->timeslot ?? 15;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.auth()->user()->zoomOAuth->access_token,
            'Content-Type' => 'application/json',
        ])->post('https://api.zoom.us/v2/users/me/meetings', [
            'topic' => $data['topic'],
            'type' => 2,
            'start_time' => $start_time->format('Y-m-d\TH:i:s'),
            'timezone' => env('timezone'),
            'duration' => $duration,
            'agenda' => $data['agenda'],
            'settings' => [
                'host_video' => false,
                'participant_video' => false,
                'waiting_room' => true,
            ],
        ]);
        if ($response->successful()) {
            $response = $response->json();
            $appointment = Appointment::find($appointment_id);
            $appointment->zoom_url = $response['join_url'];
            $appointment->save();
            if ($request->has('send_email') && $request->send_email == 1) {
                $this->sendZoomMeetingEmailToPatient($appointment_id);
            }
        } else {
            info($response);

            return redirect()->back()->with('status', 'Meeting creation failed');
        }

        return redirect()->back()->with('status', 'Meeting created successfully');
    }

    /**
     * Create a base login URL for Zoom OAuth
     * It doesn't need any parameter
     * It returns the URL to redirect the user to login to Zoom
     */
    public function createBaseLoginURL()
    {
        $zoom_settings = Setting::select('zoom_client_id', 'zoom_redirect_url')->first();
        $client_id = $zoom_settings->zoom_client_id;
        $redirect_uri = $zoom_settings->zoom_redirect_url;
        $url = 'https://zoom.us/oauth/authorize?response_type=code&client_id='.$client_id.'&redirect_uri='.$redirect_uri;

        return $url;
    }

    public function oauthCallback(Request $request)
    {
        try {
            if ($request->has('code') && $request->code != '') {
                if ($this->generateAndStoreAccessToken($request->code)) {
                    return redirect()->back()->with('status', 'Zoom Logged in successfully');
                }
            }

            return redirect()->back()->with('status', 'Zoom Logged in failed');
        } catch (Exception $e) {
            info($e);

            return redirect()->back()->with('status', 'Zoom Logged in failed');
        }
    }

    /**
     * Get the access token for the Zoom API
     * It needs the code as a parameter
     * It returns the access token
     * Zoom Provides 'code' in redirect url parameter
     */
    private function generateAndStoreAccessToken($code)
    {
        $zoom_settings = Setting::select('zoom_client_id', 'zoom_client_secret')->first();
        $client_id = $zoom_settings->zoom_client_id;
        $client_secret = $zoom_settings->zoom_client_secret;

        $response = Http::withHeaders(['Authorization' => 'Basic '.base64_encode($client_id.':'.$client_secret)])
            ->asForm()
            ->post('https://zoom.us/oauth/token', [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => $zoom_settings->zoom_redirect_url,
            ]);

        if ($response->successful()) {
            $token = $response->json();
            $zoomOAuth = ZoomOAuth::where('user_id', auth()->user()->id)->first();
            if (! $zoomOAuth) {
                $zoomOAuth = new ZoomOAuth;
                $zoomOAuth->user_id = auth()->user()->id;
            }
            $zoomOAuth->access_token = $token['access_token'];
            $zoomOAuth->refresh_token = $token['refresh_token'];
            $zoomOAuth->expires_at = $token['expires_in'];
            $zoomOAuth->token_type = $token['token_type'];
            $zoomOAuth->save();

            return true;
        } elseif ($response->status() == 401) {
            $this->refresh_token();

            return true;
        }

        return false;
    }

    /**
     * Get the refresh token for the Zoom API
     * It returns the new refresh token as [String]
     */
    public function refresh_token()
    {
        try {
            $zoom_settings = Setting::select('zoom_client_id', 'zoom_client_secret')->first();
            $client_id = $zoom_settings->zoom_client_id;
            $client_secret = $zoom_settings->zoom_client_secret;

            $response = Http::withHeaders(['Authorization' => 'Basic '.base64_encode($client_id.':'.$client_secret)])
                ->asForm()
                ->post('https://zoom.us/oauth/token', [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => Auth::user()->zoomOAuth->refresh_token,
                ]);
            if ($response->successful()) {
                $token = $response->json();
                Auth::user()->zoomOAuth->access_token = $token['access_token'];
                Auth::user()->zoomOAuth->refresh_token = $token['refresh_token'];
                Auth::user()->zoomOAuth->expires_at = $token['expires_in'];
                Auth::user()->zoomOAuth->token_type = $token['token_type'];
                Auth::user()->zoomOAuth->save();
            }
        } catch (Exception $e) {
            info($e);
        }
    }

    private function sendZoomMeetingEmailToPatient($appointment_id)
    {
        $setting = Setting::first();
        $appointment = Appointment::find($appointment_id);
        $doctor = User::find(Doctor::where('id', $appointment->doctor_id)->first()->user_id);
        $patient = User::find($appointment->user_id);

        $notification_template = NotificationTemplate::where('title', 'zoom meeting link')->first()->mail_content;

        $placeholders = [
            '{{join_url}}' => $appointment->zoom_url,
            '{{doctor_name}}' => $doctor->name,
            '{{start_time}}' => $appointment->date,
            '{{app_name}}' => $setting->business_name,
        ];

        $placeholder_keys = array_keys($placeholders);
        $placeholder_values = array_values($placeholders);
        $mail_content = str_ireplace($placeholder_keys, $placeholder_values, $notification_template);

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
                Mail::to($patient->email)->send(new SendMail($mail_content, 'Zoom Meeting Schedule'));
            } catch (\Exception $e) {
                info($e);
            }
        }
    }

    // / ZOOM MEETING CONFIGURATION
    // $requestBody = [
    //     'topic'      => $meetingConfig['topic'] ?? 'Code 180',
    //     'type'       => $meetingConfig['type'] ?? 2,
    //     'start_time' => $meetingConfig['start_time'] ?? date('Y-m-dTh:i:00') . 'Z',
    //     'duration'   => $meetingConfig['duration'] ?? 30,
    //     'password'   => $meetingConfig['password'] ?? mt_rand(),
    //     'timezone'   => 'Asia/Kolkata',
    //     'agenda'     => $meetingConfig['agenda'] ?? 'Interview Meeting',
    //     'settings'   => [
    //         'host_video'        => false,
    //         'participant_video' => true,
    //         'cn_meeting'        => false,
    //         'in_meeting'        => false,
    //         'join_before_host'  => true,
    //         'mute_upon_entry'   => true,
    //         'watermark'         => false,
    //         'use_pmi'           => false,
    //         'approval_type'     => 1,
    //         'registration_type' => 1,
    //         'audio'             => 'voip',
    //         'auto_recording'    => 'none',
    //         'waiting_room'      => false,
    //     ],
    // ];
}
