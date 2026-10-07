<?php

namespace App\Observers;

use App\Enums\AbsenceType;
use App\Models\User;

class UserObserver
{
	public function created(User $user): void
	{
		$user->balances()->createMany([
			[
				'type' => AbsenceType::DayOff->value,
				'minutes' => 0,
			],
			[
				'type' => AbsenceType::Recovery->value,
				'minutes' => 0,
			],
		]);
	}
}