<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EnvioContrasena extends Notification
{
    use Queueable;

    private $contrasena;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($contrasena)
    {
        $this->contrasena=$contrasena;
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
            //->greeting('Hello!')
            ->subject('Cuenta Creada')
            ->line('Su cuenta en el sistema ha sido creada')
            ->line('Usuario: '.$notifiable->email)
            ->line('Contraseña: '.$this->contrasena)
            ->line('Cambie su contraseña una vez que ingrese al sistema')
            ->success();
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
