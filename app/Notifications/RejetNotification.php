<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RejetNotification extends Notification
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
                  ->line('Votre demande d\aide pour le cadre de  '.$this->demande->type_demande.' a été rejeter')
                  ->line('Veuillez ressayer encore une autre demande de  '.$this->demande->type_demande.' avec de bonne information')
                  ->line('Cordialement,')
                  ->line('Le FDA-BENIN')
                  ->line('Pour toute question,merci de nous contacter en écrivant à cette addresse email')
                  ->action('mail@gmail.com', url('/'))
                  ->line('ou appeler nous au 66 96 49 17')
                  ->line('Bonne journée,')
                  ->line('L\'administration FDA');
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