<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SuspendreNotification extends Notification
{
    protected $demande;

    
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($demande)
    {
        //
        $this->demande = $demande;
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
                    ->line('FDA-BENIN')
                    ->greeting('Bonjour')
                    ->line('Votre demande d\aide pour le cadre de '.$this->demande->type_demande.' nécessite une mise à jour pour des raison de '. $this->demande->message)
                    ->line('Votre numero de demande est : '.$this->demande->code)
                    ->action('Veuillez cliquer ici pour la modification', url('/modification_demande'))
                    ->line('Cordialement,')
                    ->line('Le FDA-BENIN')
                    ->line('Pour toute question,merci de nous contacter en écrivant à cette addresse email')
                    ->line('ou appeler nous au 66 96 49 17')
                    ->line('Bonne journée,')
                    ->line('L\'equipe de la FDA-BENIN');
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