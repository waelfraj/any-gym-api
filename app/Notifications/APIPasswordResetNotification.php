<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class APIPasswordResetNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $reset_code;
    protected $userName;
    public function __construct($code,$userName){
    $this->reset_code = $code;
    $this->userName = $userName;
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
    public function toMail(): MailMessage
    {
        return (new MailMessage)->greeting('Bonjour ' . $this->userName . '!')
            ->line('Vous recevez cet e-mail car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.')
            ->line('Veuillez entrer le code ci-dessous sur votre page de réinitialisation de mot de passe.')
            ->line($this->reset_code)
            ->line('Veuillez noter que le code expirera dans 1 heure.')
            ->line('Si vous n\'avez pas demandé de réinitialisation de mot de passe, veuillez ignorer ce message.')
            ->line('Merci d\'utiliser notre application!')
            ->subject('AnyGym - Demande de réinitialisation de mot de passe.')
            ->priority(1);
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
