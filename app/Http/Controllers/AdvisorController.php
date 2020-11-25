<?php

namespace App\Http\Controllers;

use App\Advisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class AdvisorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() { $this->middleware('admin'); }

    /**
     * Show the form for creating a new advisor.
     *
     * @param Request  $request
     * @return Response
     */
    public function create(Request $request)
    {
        if (! $request->cookie('new_user_id')) {
            return redirect('register');
        }

        return view('advisors.create')->withAdvisor(new Advisor);
    }

    /**
     * Store a newly created advisor in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        Advisor::create($this->addAttributes($request, 'new_user_id'));

        return view('common.message', [
            'message' => 'Advisor user created successfully.'
        ])->withType('success');
    }

    /**
     * Show the form for editing the specified advisor.
     *
     * @param  Advisor  $advisor
     * @return Response
     */
    public function edit(Advisor $advisor)
    {
        return view('advisors.edit')->withAdvisor($advisor);
    }

    /**
     * Update the specified advisor in storage.
     *
     * @param  Request  $request
     * @param  Advisor  $advisor
     * @return Response
     */
    public function update(Request $request, Advisor $advisor)
    {
        $this->validator($request->all())->validate();

        $advisor->update($this->addAttributes($request, 'edit_user_id'));

        return view('common.message', [
            'message' => 'Advisor user edited successfully.'
        ])->withType('success');
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
            'admin' => 'nullable|in:0,1,on',
            'duty'  => 'nullable|in:0,1,on',
            'title' => 'required|in:Mr,Ms,Mrs,Dr'
        ]);
    }

    /**
     * Add the necessary attributes to the $request array.
     *
     * @param  Request  $request
     * @param  string  $cookie
     * @return Advisor
     */
    private function addAttributes(Request $request, $cookie) {
        $data = $request->all();

        $data['user_id'] = decrypt($request->cookie($cookie));
        $data['admin']   = (bool) ($data['admin'] ?? false);
        $data['duty']    = (bool) ($data['duty'] ?? false);

        Cookie::queue(Cookie::forget($cookie));

        return $data;
    }

}
