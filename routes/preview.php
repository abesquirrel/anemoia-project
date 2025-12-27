<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Notifications\Messages\MailMessage;

Route::get('/preview-mail', function () {
    $message = (new MailMessage)
        ->subject('Reset Password Notification')
        ->line('You are receiving this email because we received a password reset request for your account.')
        ->action('Reset Password', url('password/reset', 'token'))
        ->line('If you did not request a password reset, no further action is required.');

    return $message->render();
});
