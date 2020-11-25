<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Notifications\OvernightAuthorisationReceived;

class OvernightAuthorisationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('advisor');
    }

    /**
     * Create an overnight trip authorisation for the $student.
     * 
     * @param  Student  $student
     * @param  Request  $request
     * @return Response
     */
    public function store(Student $student, Request $request)
    {
        abort_if(Gate::denies('access-student', $student), 403);

        $authorisation = array_merge(
            $request->validate([
                'leave_date'  => 'required|date|after_or_equal:today',
                'return_date' => 'required|date|after_or_equal:leave_date'
            ]),
            ['advisor_id' => app('user')->id]
        );

        $student->authorisation()->create($authorisation);

        $student->user->notify(new OvernightAuthorisationReceived(
            app('user')->name, $authorisation
        ));

        return back();  // TODO: display success/error msg
    }

    /**
     * Delete the $student's overnight trip authorisation.
     * 
     * @param  Student  $student
     * @return Response
     */
    public function destroy(Student $student)
    {
        abort_if(Gate::denies('access-student', $student), 403);

        $student->authorisation->delete();

        return back();
    }
}
