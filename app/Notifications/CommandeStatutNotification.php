<?php

namespace App\Notifications;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommandeStatutNotification extends Notification
{
    use Queueable;

    public function __construct(protected Commande $commande)
    {
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $statut = ucfirst(str_replace('_', ' ', $this->commande->statut));
        $type = ucfirst(str_replace('_', ' ', $this->commande->type_commande));

        $suiviUrl = \URL::signedRoute('commandes.suivi', ['id' => $this->commande->id]);

        return (new MailMessage)
            ->subject("Mise à jour de votre commande #{$this->commande->id}")
            ->greeting('Bonjour,')
            ->line("Le statut de votre commande a changé : **{$statut}**")
            ->line("Type de commande : {$type}")
            ->line('Total : ' . number_format((float) $this->commande->total, 0, ',', ' ') . ' FCFA')
            ->action('Suivre ma commande', $suiviUrl)
            ->salutation("Cordialement, l'équipe Eat&Drink");
    }
}
