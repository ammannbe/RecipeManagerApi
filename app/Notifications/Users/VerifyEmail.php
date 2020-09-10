<?php

namespace App\Notifications\Users;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;

class VerifyEmail extends BaseVerifyEmail
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  \App\Models\Users\User  $user
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if ($notifiable->exists) {
            return parent::toMail($notifiable);
        }

        $password = \Str::random(10);
        $notifiable->password = \Hash::make($password);
        $notifiable->save();
        $notifiable->markEmailAsVerified();

        $loginUrl = route('login');

        return (new MailMessage)
            ->subject(\Lang::get('Account created'))
            ->line(\Lang::get('A new account was created for you.'))
            ->line(\Lang::get('Use the following password to login: :password', ['password' => $password]))
            ->action(\Lang::get('Login'), $loginUrl)
            ->line(\Lang::get('You should change your password after the first login.'));
    }
}
