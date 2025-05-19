<?php

namespace App\Notifications;

use App\Models\Dish;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Xefi\Faker\Faker;

class NewDish extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(Dish $dish)
    {
        $this->dish = $dish;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $dish = $this->dish;

        return (new MailMessage)
            ->view('emails.newdish', ['dish' => $dish]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
