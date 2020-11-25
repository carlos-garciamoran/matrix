<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OvernightAuthorisationReceived extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param string  $advisor_name
     * @param array   $authorisation
     * @return void
     */
    public function __construct($advisor_name, $authorisation)
    {
        $this->advisor = $advisor_name;
        $this->authorisation = $authorisation;
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
        return (new MailMessage)
            ->line($this->advisor . ' has authorised you to sign out for an ' . 
                   'overnight trip with the following details:')
            ->line('    - leave date: ' . $this->authorisation['leave_date'])
            ->line('    - return date: ' . $this->authorisation['return_date'])
            ->action('Sign out', url('sign-out'));
    }
}
