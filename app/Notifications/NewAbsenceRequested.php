<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAbsenceRequested extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param array  $absence
     * @return void
     */
    public function __construct($absence)
    {
        $this->absence = $absence;
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
        $name = User::find($this->absence->advisor_id)->name;

        return (new MailMessage)
                    ->line('Absence request details:')
                    ->line("\t- teacher: " . $name)
                    ->line("\t- leave date: " . $this->absence->leave_date)
                    ->line("\t- return date: " . $this->absence->return_date)
                    ->line("\t- reason: " . $this->absence->reason)
                    ->line("\t- comment: " . $this->absence->comment)
                    ->line('Approve or reject at the absences panel.')
                    ->action('Absences panel', url('/absences'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
