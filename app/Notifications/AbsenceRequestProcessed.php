<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AbsenceRequestProcessed extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param boolean  $approved
     * @return void
     */
    public function __construct($approved)
    {
        $this->approved = $approved;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $outcome = $this->approved ? 'approved' : 'rejected';

        return (new MailMessage)
            ->line('Your absence request has been ' . $outcome . '.');
    }
}
