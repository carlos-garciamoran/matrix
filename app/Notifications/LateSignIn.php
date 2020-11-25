<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class LateSignIn extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param string  $type
     * @param string  $student
     * @return void
     */
    public function __construct($type, $student = null)
    {
        $this->type = $type;
        $this->student = $student;
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
        if ($this->type === 'advisor') {
            return (new MailMessage)
                ->subject($this->student . ' is late for sign in')
                ->line('The student has also been notified.');
        }

        return (new MailMessage)
            ->action('Sign In', url('sign-in'))
            ->line('This email will be sent every hour.');
    }
}
