<?php

namespace App\Http\Controllers;

use App\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OvernightAuthorisationRequest;

class TripController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('student');
    }

    /**
     * Sign out the student by creating a new trip.
     *
     * @param  Request  $request
     * @return Response
     */
    public function signOut(Request $request)
    {
        $student = app('student');

        if ($student->openTrips->count() >= 1) {
            return view('common.message', [
                'message' => 'You have already signed out successfully.'
            ])->withType('error');
        }

        $trip = $this->validateSignOut($request);
        // dd($trip);
        if (strtotime($trip['return_date']) > strtotime(date('Y-m-d 22:00')) ||
            strtotime(now())                > strtotime(date('Y-m-d 22:00'))) {

            $trip['overnight'] = true;

            // TODO: throttle requests so that email is not sent more than once.
            if (! $student->hasAuthorisation()) {
                Notification::send($student->advisors('as_user'),
                    new OvernightAuthorisationRequest(app('user')->name, $trip)
                );

                return back()->withErrors(
                    'Your advisor(s) has not authorised you to leave for overnight. We just notified them to do so.'
                );
            }

            elseif ($student->authorisation->leave_date  !== substr(now()->toDateTimeString(), 0, 10) ||
                    $student->authorisation->return_date !== substr($trip['return_date'], 0, 10)) {
                return back()->withErrors(
                    'You are only authorised for signing out on the ' . date("d-m-Y", strtotime($student->authorisation->leave_date)) .
                    ' and return on the ' . date("d-m-Y", strtotime($student->authorisation->return_date)) . '.'
                );
            }

            $student->authorisation->delete();
        }

        // TODO: before booking phone, check if available
        if (isset($trip['school_phone'])) $this->setPhone($trip['school_phone'], false, app('user')->name);

        $tripData = $student->trips()->create($trip);

        $this->logTrip('Sign Out', $tripData);

        return view('common.message', [
            'message' => 'You\'ve signed out successfully.'
        ])->withType('success');
    }

    /**
     * Sign in the student by closing the last trip created.
     *
     * @return Response
     */
    public function signIn()
    {
        $trip = app('student')->openTrips->first();

        if ($trip === null) {
            return view('common.message', [
                'message' => 'You have already signed in successfully.'
            ])->withType('error');
        }

        if ($trip->school_phone !== null) $this->setPhone($trip['school_phone'], true);

        $trip->signed_in = true;
        $trip->save();

        $this->logTrip('Sign In', $trip);

        return view('common.message', [
            'message' => 'You\'ve signed in successfully.'
        ])->withType('success');
    }

    /**
     * Call validate() on $request.
     *
     * @param  Request  $request
     * @return Reponse|array  [If validation passes return the pass object.]
     */
    private function validateSignOut($request)
    {
        $trip = $request->validate([
            'return_date'  => 'required|date|after:now',
            'destination'  => 'required|min:3|max:50',
            'school_phone' => 'nullable|numeric|between:1,26',
            'charger'      => 'nullable|boolean'
        ]);

        return $trip;
    }

    /**
     * Set the phone availability in the DB and assign a holder if inputed.
     *
     * @param  int  $id
     * @param  bool  $availability
     * @param  string|null  $holder
     * @return void
     */
    private function setPhone($id, $availability, $holder = null)
    {
        DB::table('school_phones')->where('id', $id)
            ->update(['availability' => $availability, 'holder' => $holder]);
    }

    /**
     * Log the trip data to a CSV file.
     *
     * @param  string  $action
     * @param  array  $data
     * @return null
     */
    private function logTrip($action, $data)
    {
        // IMPROVEMENT: refactorise this into an event triggered by the 2 methods
        $fp = fopen(config('filesystems.disks.local.root') . '/trips-log.csv', 'a+');
        fputcsv($fp, array_merge($data->toArray(), ['action' => $action]));
        fclose($fp);
    }
}
