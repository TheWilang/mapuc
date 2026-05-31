<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // 🔥 LINK ACTUALIZADO A /change
        $resetUrl = url('/change/' . $this->token . '?email=' . urlencode($notifiable->email));

        return (new MailMessage)
            ->subject('Restablecer contraseña')
            ->line('Haz solicitado restablecer tu contraseña.')
            ->action('Cambiar contraseña', $resetUrl)
            ->line('Si no solicitaste este mensaje, ignóralo.');
    }
}
