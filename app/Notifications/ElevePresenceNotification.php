<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ElevePresenceNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $eleve;
    protected $date;
    public function __construct($eleve, $date)
    {
        $this->eleve = $eleve;
        $this->date = $date;
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
        return (new MailMessage)
                    ->subject('Présence de votre enfant')
                    ->greeting('Bonjour ' . $notifiable->name)
                    ->line('Nous vous informons que votre enfant ' . $this->eleve->nom . ' ' . $this->eleve->prenom . ' est bien arrivé à l\'école le ' . $this->date . '.')
                    ->line('Merci de votre attention.')
                    ->salutation('Cordialement, L\'école');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'eleve_id' => $this->eleve->id,
            'date' => $this->date,
        ];
    }
}
