<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class ExpenseCreated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $expense;

    /**
     * Create a new notification instance.
     *
     * @param $expense
     */
    public function __construct($expense)
    {
        $this->expense = $expense;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $date = Carbon::parse($this->expense->date);

        return (new MailMessage)
                    ->subject('New registered expense: ' . $this->expense->description)
                    ->line($notifiable->name . ', a new expense named "' . $this->expense->description . '" was registered.')
                    ->line('**Value:** R$' . number_format($this->expense->value, 2, ',', '.') . ' | **Date:** ' . $date->format('d/m/Y'))
                    ->line('Thank you for being part of the team.')
                    ->salutation('Best Regards, Simplify with Onfly!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'id' => $this->expense->id,
            'value' => $this->expense->value,
        ];
    }
}
