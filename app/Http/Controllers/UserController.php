<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        parent::__construct();
        $this->middleware('admin')->except('show');
        $this->middleware('advisor')->only('show');
    }

    /**
     * Display a listing of the users.
     *
     * @param  Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if (! $request->input('query')) { $users = User::orderBy('email'); }
        else {
            $users = User::where('name', 'like', '%'.strtolower($request->input('query')).'%');
        }

        return view('users.index')->withUsers($users->paginate(20));
    }

    /**
     * Display the specified user.
     *
     * @param  User  $user
     * @return Response
     */
    public function show(User $user)
    {
        if ($user->isStudent()) {
            abort_if(Gate::denies('access-student', $user->student), 403);
        }

        return view('users.show')->withUser($user);
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  User  $user
     * @return Response
     */
    public function edit(User $user)
    {
        return view('users.edit')->withUser($user);
    }

    /**
     * Update the specified user in storage.
     *
     * @param  Request  $request
     * @param  User  $user
     * @return Response
     */
    public function update(Request $request, User $user)
    {
        // Attributes blocked for security reasons.
        $data = $request->except(['password', 'remember_token', 'name', 'role']);

        $data['name'] = "{$data['first_name']} {$data['last_name']}";

        $this->validator($data, $user->id)->validate();

        if (isset($data['profile_photo'])) {
            $data['profile_photo'] = substr(
                $data['profile_photo']->store('images/profile-photos', 'public'),
                22
            );
        }

        $user->update($data);

        if ($user->isStudent()) {
            return redirect(url('students/' . $user->id . '/edit'))
                ->cookie('edit_user_id', encrypt($user->id), 1440);
        }

        return redirect(url('advisors/' . $user->id . '/edit'))
            ->cookie('edit_user_id', encrypt($user->id), 1440);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @param  int  $user
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data, $user_id)
    {
        $error_messages = [
            'email.regex' => 'Please register the user with their school email address.'
        ];

        return Validator::make($data, [
            'profile_photo' => 'nullable|image',
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'email'         => 'required|email|max:255|regex:/(.*)uwcisak\.jp$/i|'
                            . Rule::unique('users')->ignore($user_id),
        ], $error_messages);
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  User  $user
     * @return Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return back(); // TODO: attach message saying 'user deleted successfully'
    }
}
