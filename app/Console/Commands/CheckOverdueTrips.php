<?php

namespace App\Console\Commands;

use App\Trip;
use App\User;
use App\Notifications\LateSignIn;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class CheckOverdueTrips extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'matrix:check-overdue-trips';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if any of the open trips is overdue and if '
                           . 'so, notify the user.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() { parent::__construct(); }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // IDEA: add notification tasks dynamically on sign out and remove them
        //       on sign in so that we reduce SQL queries
        $openTrips = Trip::all()->where('signed_in', false);

        $overdueTrips = $openTrips->map(function($trip) {
            if (strtotime(now()) > strtotime($trip->return_date)) {
                return $trip;
            }
        });

        foreach ($overdueTrips as $trip) {
            if ($trip === null) continue;

            $user = User::find($trip->student_id);

            $user->notify(new LateSignIn('student'));

            if (! $trip->overdue_notification) {
                $trip->overdue_notification = 1;
                $trip->save();

                Notification::send(
                    $user->student->advisors('as_user'),
                    new LateSignIn('advisor', $user->name)
                );
            }
        }
    }
}
