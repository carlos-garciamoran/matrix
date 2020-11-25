<?php

namespace App\Http\Controllers;

use App\Absence;
use App\Notifications\AbsenceRequestProcessed;
use App\Notifications\NewAbsenceRequested;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AbsenceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        parent::__construct();
        $this->middleware('advisor');
        $this->middleware('admin')->only(['index', 'approve', 'reject']);
    }

    /**
     * Display a listing of the users.
     *
     * @return Response
     */
    public function index()
    {
        return view('absences.index')->withAbsences(Absence::with('user')->get());
    }

    /**
     * Show the form for creating a new advisor.
     *
     * @return Response
     */
    public function create()
    {
        return view('absences.create');
    }

    /**
     * Store a newly created absence in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        // V1.1: limit the number of requests a teacher can create
        // V1.1: notify admin users about absence request

        $data = $request->validate([
            'leave_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after:leave_date',
            'reason' => [
                'required', 'string', Rule::in([
                    'Medical', 'Personal', 'Professional development', 'School-related'
                ])],
            'comment' => 'nullable|string|min:5,max:500',
        ]);

        $absence = app('advisor')->absences()->create($data);

        User::where('email', 'matrix@uwcisak.jp')->first()
            ->notify(new NewAbsenceRequested($absence));

        return view('common.message', [
            'message' => 'Absence request created successfully. You will be '.
                         'emailed when your request is processed.'
        ])->withType('success');
    }

    /**
     * Display the absences for the given user.
     *
     * @param  User  $user
     * @return Response
     */
    public function history(User $user)
    {
        return view('absences.history')
            ->withAbsences($user->absences)
            ->withUser($user);
    }

    /**
     * Approve an absence request.
     *
     * @param  Absence  $absence
     * @return Response
     */
    public function approve(Absence $absence)
    {
        $this->process($absence, true);

        // TODO: return back
        return view('common.message', [
            'message' => 'Absence request approved. The teacher has been notified.'
        ])->withType('success');
    }

    /**
     * Reject an absence request.
     *
     * @param  Absence  $absence
     * @return Response
     */
    public function reject(Absence $absence)
    {
        $this->process($absence, false);

        return view('common.message', [
            'message' => 'Absence request rejected. The teacher has been notified.'
        ])->withType('success');
    }

    /**
     * Process an absence request.
     *
     * @param  Absence  $absence
     * @param  string  $approved
     * @return null
     */
    private function process(Absence $absence, $approved)
    {
        $absence->approved = $approved;
        $absence->save();

        $absence->user->notify(new AbsenceRequestProcessed($approved));
    }
}
