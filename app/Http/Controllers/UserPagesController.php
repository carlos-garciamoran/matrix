<?php

namespace App\Http\Controllers;

class UserPagesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Redirect the user to the news dashboard.
     * 
     * @return Response
     */
    public function home()
    {
        return redirect('posts');
    }

    /**
     * Show the profile of the logged in user.
     * 
     * @return Response
     */
    public function profile() {
        return view('users.show')->withUser(app('user'));
    }
}
