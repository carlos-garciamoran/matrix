<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdvisorPagesController extends Controller
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
     * Show the list of students who belong to the advisor.
     * 
     * @return Response
     */
    public function advisory()
    {
        // TODO: eager-load trip queries (openTrips + isOncampus/isLate)
        return view('students.index', [
            'students' => app('advisor')->students()
                ->with(['user', 'authorisation'])->get()->sortBy('user.email'),
            'title' => 'Advisory'
        ]);
    }

    /**
     * Show the trip history of the student.
     * 
     * @param  Student $student
     * @return Response
     */
    public function history(Student $student)
    {
        abort_if(Gate::denies('access-student', $student), 403);

        return view('trips.history', [
            'student' => $student,
            'trips'   => $student->trips()->latest()->paginate(20)
        ]);
    }
}
