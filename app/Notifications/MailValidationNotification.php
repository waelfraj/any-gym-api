<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MailValidationNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $validation_code;
    protected $userName;
    public function __construct($validation_code,$userName){
        $this->validation_code = $validation_code;
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
        return (new MailMessage)
            ->greeting('Bienvenue ' . $this->userName . '!')
            ->line('Merci de vous être inscrit(e) sur AnyGym. Nous sommes ravis de vous accueillir !')
            ->line('Pour assurer la sécurité de votre compte et accéder à toutes les fonctionnalités, veuillez vérifier votre adresse e-mail.')
            ->line('Veuillez entrer le code de validation ci-dessous dans le champ prévu à cet effet :')
            ->line($this->validation_code)
            ->line('Veuillez noter que le code de validation expirera dans 24 heures.')
            ->line('Si vous n\'avez pas créé de compte sur AnyGym, veuillez ignorer ce message.')
            ->line('Nous sommes impatients de vous offrir une expérience exceptionnelle !')
            ->subject('Bienvenue sur AnyGym - Validation de l\'adresse e-mail')
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
