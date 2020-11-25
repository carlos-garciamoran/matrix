<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class DailyNews extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param array  $announcements
     * @param array  $reminders
     * @return void
     */
    public function __construct($announcements, $reminders)
    {
        $this->announcements = $announcements;
        $this->reminders = $reminders;
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
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('The Bearly Awake | ' . today()->format('D, M j, Y'))
            ->view('mail.daily-news', [
                'announcements' => $this->announcements,
                'reminders' => $this->reminders
            ]);
    }
}
