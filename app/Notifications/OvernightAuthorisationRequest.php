<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OvernightAuthorisationRequest extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param string  $student_name
     * @return void
     */
    public function __construct($student_name, $trip_info)
    {
        $this->student = $student_name;
        $this->trip = $trip_info;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via() { return ['mail']; }

    /**
     * Get the mail representation of the notification.
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail()
    {
        // TODO: change format of date (YYYY-MM-DD => DD-MM-YYYY)
        return (new MailMessage)
            ->line("The student {$this->student} has requested authorisation for signing out.")
            ->line("The overnight trip details are the following:")
            ->line("\t- destination: {$this->trip['destination']}")
            ->line("\t- return-date: " . substr($this->trip['return_date'], 0, 10))
            ->action('Advisory panel', url('advisory'));
    }
}
