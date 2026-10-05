<?php

namespace App\Observers;

use App\Enums\RequestTypes;
use App\Models\User;

class UserObserver
{
	public function created(User $user): void
	{
		$user->balances()->createMany([
			[
				'type' => RequestTypes::DayOff->value,
				'minutes' => 0,
			],
			[
				'type' => RequestTypes::Recovery->value,
				'minutes' => 0,
			],
		]);
	}
}