<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Notifications\AccountCreated;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() { $this->middleware('admin'); }

    /**
     * Show the application registration form.
     *
     * @return Response
     */
    public function showRegistrationForm()
    {
        return view('users.create', [ 'user' => new User ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $error_messages = [
            'email.regex' => 'Please register the user with their school email address.'
        ];

        // TODO: validate image size and MIME type + ext before storing

        return Validator::make($data, [
            'profile_photo' => 'nullable|image',
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'role'          => 'required|in:advisor,staff,student',
            'email'         => 'required|email|max:255|unique:users|' . 
                               'regex:/(.*)uwcisak\.jp$/i',
            // TODO: use a dedicated validation rule [substr(config('app.url'), 8)]
        ], $error_messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // IDEA: resize image to a fixed rate before storing
        if (isset($data['profile_photo'])) {
            $data['profile_photo'] = substr(
                $data['profile_photo']->store('images/profile-photos', 'public'),
                22
            );
        }

        $user = User::create(array_merge($data, [
            'name'     => $data['first_name'] . ' ' . $data['last_name'],
            'password' => Hash::make(str_random(15))
        ]));

        return $user;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  Request  $request
     * @return Response
     */
    public function register(Request $request)
    {
        // IDEA: postpone user creation (register()) until student/advisor
        //       profile has been created.

        $this->validator($request->all())->validate();

        return $this->registered($this->create($request->all()));
    }

    /**
     * The user has been registered.
     *
     * @param  User  $user
     * @return mixed
     */
    protected function registered(User $user)
    {
        $user->notify(new AccountCreated);

        if ($user->isStaff()) {
            return view('common.message', [
                'message' => 'User created successfully.'
            ])->withType('success');
        }

        return redirect(url($user->role . 's/create'))
            ->cookie('new_user_id', encrypt($user->id), 1440);
    }
}
