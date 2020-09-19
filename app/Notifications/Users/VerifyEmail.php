<?php

namespace App\Notifications\Users;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;

class VerifyEmail extends BaseVerifyEmail
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  \App\Models\Users\User  $notifiable
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

        // This is mainly a phpstan fix
        $subject = !is_array(\Lang::get('Account created')) ? \Lang::get('Account created') : 'Account created';
        $action = !is_array(\Lang::get('Login')) ? \Lang::get('Login') : 'Login';

        return (new MailMessage)
            ->subject($subject)
            ->line(\Lang::get('A new account was created for you.'))
            ->line(\Lang::get('Use the following password to login: :password', ['password' => $password]))
            ->action($action, $loginUrl)
            ->line(\Lang::get('You should change your password after the first login.'));
    }
}
