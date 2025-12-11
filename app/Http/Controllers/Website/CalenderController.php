<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use Carbon\Carbon;

class CalenderController extends Controller
{
    /**
     * Generate a Google Calendar event link for the appointment.
     *
     * This function dynamically builds a URL to create a Google Calendar event based on provided details.
     * It supports event title, description, start and end times, recurrence, and timezone.
     *
     * @param  string  $eventName  The name or title of the event (e.g., 'Meeting with Client'). Default: 'Unnamed Event'
     * @param  string  $details  Additional details or description for the event (e.g., 'Discuss project details'). default: ''
     * @param  string  $startDateTime  The start date and time of the event in `YYYY-MM-DD HH:MM:SS` format (e.g., '2024-09-12 12:00:00').
     * @param  string  $endDateTime  The end date and time of the event in `YYYY-MM-DD HH:MM:SS` format (e.g., '2024-09-12 12:00:00').
     * @param  string  $timezone  The timezone for the event (e.g., 'America/New_York').
     *                            Defaults to 'UTC'.
     * @return string The generated Google Calendar event URL that can be used in an anchor tag or redirected to.
     *
     * Example usage:
     * ```php
     * $calendarLink = createGoogleCalendarLink(
     *     'Appointment with Dr. Smith',
     *     'I have fever and headache.',
     *     '2024-09-12 12:00:00',
     *     '2024-09-12 13:00:00',
     *     'America/New_York',
     * );
     * echo $calendarLink;
     * ```
     */
    private function createGoogleCalendarLink(
        string $appointmentTitle,
        string $appointmentDescription,
        string $appointmentDateTimeFrom,
        string $appointmentDateTimeTo,
        string $timezone = 'UTC',
    ): string {
        // Base URL for Google Calendar event creation
        $baseUrl = 'https://calendar.google.com/calendar/render?action=TEMPLATE';
        $appointmentDateTimeFrom = Carbon::parse($appointmentDateTimeFrom)->format('Ymd\THis');
        $appointmentDateTimeTo = Carbon::parse($appointmentDateTimeTo)->format('Ymd\THis');

        // Prepare query parameters
        $params = [
            'text' => urlencode($appointmentTitle),
            'details' => urlencode($appointmentDescription),
            'dates' => $appointmentDateTimeFrom.'/'.$appointmentDateTimeTo,
            'ctz' => urlencode($timezone),
        ];

        // Build the final Google Calendar link with all parameters
        $calendarUrl = $baseUrl.'&'.http_build_query($params);

        return rawurldecode($calendarUrl);
    }

    public function createGoogleCalendarLinkForAppointment($appointment_id)
    {
        $patientID = auth()->user()->id;

        if (! $appointment_id) {
            return redirect()->back()->with('error', 'Appointment ID is required');
        }

        $appointment = Appointment::find($appointment_id);

        if (! $appointment) {
            return redirect()->back()->with('error', 'Appointment not found');
        }

        if ($appointment->user_id != $patientID) {
            return redirect()->back()->with('error', 'Appointment not found');
        }

        $doctor = Doctor::find($appointment->doctor_id);
        $appointmentDateTimeFrom = Carbon::parse($appointment->date.' '.$appointment->time)->format('Y-m-d H:i:s');
        $appointmentDateTimeTo = Carbon::parse($appointmentDateTimeFrom)->addMinutes($doctor->timeslot)->format('Y-m-d H:i:s');

        $appointmentTitle = 'Appointment with '.$doctor->name;
        $appointmentDescription = $appointment->illness_information;

        $calendarLink = $this->createGoogleCalendarLink($appointmentTitle, $appointmentDescription, $appointmentDateTimeFrom, $appointmentDateTimeTo, config('app.timezone'));

        return redirect($calendarLink);
    }
}
