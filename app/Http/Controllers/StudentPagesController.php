<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class StudentPagesController extends Controller
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
     * Show the sign in form.
     * 
     * @return Response
     */
    public function signIn() {
        return view('trips.sign-in');
    }

    /**
     * Show the sign out form.
     * 
     * @return Response
     */
    public function signOut()
    {
        return view('trips.sign-out', [
            'phones' => DB::table('school_phones')->where('availability', true)->get()
        ]);
    }
}
