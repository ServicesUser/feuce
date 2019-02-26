<?php

namespace App\Notifications;

use App\Campana;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AvisoEleccion extends Notification
{
    use Queueable;

    protected $eleccion;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Campana $nueva)
    {
        $this->eleccion=$nueva;
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
        return (new MailMessage)
                    ->line($this->eleccion->detalle_ca)
                    ->line('')
                    ->line('Recuerda votar desde tu intranet')
                    ->line('Fecha: '.$this->eleccion->dia)
                    ->line('Desde '.$this->eleccion->desde.' hasta '.$this->eleccion->hasta);
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
