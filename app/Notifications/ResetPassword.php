<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;


//use Illuminate\Notifications\Notification;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;


//
//
//
//{}


class ResetPassword extends ResetPasswordNotification
//class ResetPassword extends Notification
{
    use Queueable;
    public $token;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
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

        //$link = url( "admin/password/reset/?token=" . $this->token );
        $link = url( "admin/password/reset/" . $this->token );

        return ( new MailMessage )
            //->view('reset.emailer')
            ->from('info@example.com')
            ->subject( 'Reset your password'  . config('app.name'))
            ->line( "Hey, We've successfully changed the text " . $this->token )
            ->action( 'Reset Password', $link )
            //->attach('reset.attachment')
            ->line( 'Thank you!' )
            ->line( 'End' );
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
