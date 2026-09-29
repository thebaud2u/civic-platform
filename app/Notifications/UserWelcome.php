<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserWelcome extends Notification
{
	public function __construct(public string $token) {}

	public function via($notifiable): array
	{
		return ['mail'];
	}

	public function toMail($notifiable): MailMessage
	{
		$url = url(route('password.reset', [
			'token' => $this->token,
			'email' => $notifiable->getEmailForPasswordReset(),
		], false));

		$expire = config('auth.passwords.admins.expire');

		return (new MailMessage)
			->subject('Votre compte '.config('app.name'))
			->greeting('Bonjour '.$notifiable->first_name.',')
			->line('Un compte a été créé pour vous sur '.config('app.name').'.')
			->line('Cliquez sur le bouton ci-dessous pour définir votre mot de passe.')
			->action('Définir mon mot de passe', $url)
			->line("Ce lien expire dans {$expire} minutes.");
	}
}