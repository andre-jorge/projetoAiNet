<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReciboPago extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $recibo;
    public function __construct($recibo)
    {
        $this->recibo = $recibo;
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
        $url = url('/invoices/1');
        $path = storage_path('app/pdf_recibos/1.pdf');
        // $url = url('/invoice/' . $this->invoice->id);
        // $path = storage_path('app/invoices/' . $this->invoice->fileName);
        return (new MailMessage)
            ->greeting('Hello!')
            ->line('One of your invoices has been paid!')
            ->line('It is available online')
            ->action('View Invoice', $url)
            ->line('The file is also available as an attachment in this email')
            ->line('Thank you for using our application!')
            ->attach($path);
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
