<?php

namespace App\Notifications;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ReservationStatusChanged extends Notification
{
    use Queueable;

    protected $reservation;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $status = match($this->reservation->status) {
            'approved' => 'approuvée',
            'rejected' => 'rejetée',
            default => 'en attente'
        };

        return (new MailMessage)
            ->subject('Mise à jour de votre réservation')
            ->greeting('Bonjour ' . $notifiable->first_name)
            ->line('Le statut de votre réservation a été mis à jour.')
            ->line('Votre réservation est maintenant ' . $status . '.')
            ->line('Espace : ' . $this->reservation->coworking->name)
            ->line('Date de début : ' . $this->reservation->datestart->format('d/m/Y H:i'))
            ->line('Date de fin : ' . $this->reservation->dateend->format('d/m/Y H:i'))
            ->action('Voir les détails', url('/reservations/' . $this->reservation->id));
    }

    public function toArray($notifiable)
    {
        return [
            'reservation_id' => $this->reservation->id,
            'status' => $this->reservation->status,
            'coworking_name' => $this->reservation->coworking->name,
            'datestart' => $this->reservation->datestart,
            'dateend' => $this->reservation->dateend,
        ];
    }
} 