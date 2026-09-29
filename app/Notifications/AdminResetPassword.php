<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;

class AdminResetPassword extends ResetPassword
{
	protected function resetUrl($notifiable)
	{
		return url(route('back-office.password.reset', [
			'token' => $this->token,
			'email' => $notifiable->getEmailForPasswordReset(),
		], false));
	}
}