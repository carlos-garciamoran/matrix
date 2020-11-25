<?php

namespace App\Http\Controllers;

use App\Advisor;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;


class StudentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('admin')->except('index');
        $this->middleware('duty_advisor')->only('index');
    }

    /**
     * Display a listing of the students.
     *
     * @param  Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        // TODO: eager-load trip queries (openTrips + isOncampus/isLate)
        $house_search = $request->has('residence') && $request->has('house');
        $off_campus_search = $request->has('off-campus');

        if ($house_search) {
            $students = Student::with(['user', 'authorisation'])
                ->where('residence', $request->residence)
                ->where('house', $request->house);
        }
        elseif ($off_campus_search) {
            // TODO: simplify query & eager load trips !!!
            $students = Student::with(['user', 'authorisation', 'trips'])->get()
                ->map(function($student) {
                    if (! $student->isOnCampus()) { return $student; }
                })->filter();
        }
        else { $students = Student::with(['user', 'authorisation']); }

        // TODO: sortBy('user.email') + pagination
        return view('students.index', [
            'students' => $off_campus_search
                            ? $students
                            : $students->orderBy('grade')->paginate(20),
            'title'    => $house_search
                            ? 'R' . $request->residence . '-' .  $request->house
                            : 'Residential Team'
        ]);
    }

    /**
     * Show the form for creating a new student.
     *
     * @param Request  $request
     * @return Response
     */
    public function create(Request $request)
    {
        if (! $request->cookie('new_user_id')) {
            return redirect('register');
        }

        return view('students.create', [
            'advisors' => Advisor::all()->map->user,
            'student'  => new Student
        ]);
    }

    /**
     * Store a newly created student in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        Student::create($this->checkCookie($request, 'new_user_id'))
            ->advisors()->attach($request->all()['advisors']);

        return view('common.message', [
            'message' => 'Student user created successfully.'
        ])->withType('success');
    }

    /**
     * Show the form for editing the specified student.
     *
     * @param  Student  $student
     * @return Response
     */
    public function edit(Student $student)
    {
        return view('students.edit', [
            'advisors' => Advisor::all()->map->user,
            'student'  => $student
        ]);
    }

    /**
     * Update the $student object in storage.
     *
     * @param  Request  $request
     * @param  Student  $student
     * @return Response
     */
    public function update(Request $request, Student $student)
    {
        $this->validator($request->all())->validate();

        $student->advisors()->detach();
        $student->advisors()->attach($request->all()['advisors']);

        $student->update($this->checkCookie($request, 'edit_user_id'));

        return view('common.message', [
            'message' => 'Student user edited successfully.'
        ])->withType('success');

        // TODO: return redirect('users') with success message (via session)
    }

    /**
     * Get a validator for an incoming write request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validator(array $data)
    {
        return Validator::make($data, [
            'advisors'   => 'required|array',
            'advisors.*' => 'integer',
            'birthdate'  => 'nullable|date',
            'country'    => 'required|max:50|string',
            'grade'      => 'required|in:10,11,12',
            'nickname'   => 'nullable|max:50|string',
            'phone'      => 'nullable|max:30|unique:students',
            'residence'  => 'required|in:1,2,3,4',
            'house'      => 'required|in:10,11,12,13,14,15,20',
            'room'       => 'required|in:A,B,C,D,E,F,G'
        ]);
    }

    /**
     * Decrypt the user ID from the cookie and add it to the $request attributes.
     *
     * @param  Request  $request
     * @param  string  $cookie_name
     * @return array
     */
    private function checkCookie(Request $request, $cookie_name) {
        $data = $request->all();

        $data['user_id'] = decrypt($request->cookie($cookie_name));

        Cookie::queue(Cookie::forget($cookie_name));

        return $data;
    }
}
