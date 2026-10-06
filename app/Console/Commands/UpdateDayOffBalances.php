<?php

namespace App\Console\Commands;

use App\Enums\RequestTypes;
use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

#[Signature('app:update-day-off-balances')]
#[Description('Update users day off balances every month')]
class UpdateDayOffBalances extends Command
{
	public function handle(): int
	{
		User::with(['workSchedule', 'dayOffBalance'])->each(function (User $user) {
			if (!$user->workSchedule) {
				return;
			}

			$balance = $user->dayOffBalance;
			$weeklyHours = $user->workSchedule?->weekly_hours;

			$dailyMinutes = $weeklyHours !== null
				? $weeklyHours / 5 * 60
				: 420;

			$minutes = (int) round($dailyMinutes * 2.5);

			DB::transaction(function () use ($balance, $minutes) {
				$balance->increment('minutes', $minutes);

				$balance->transactions()->create([
					'type' => RequestTypes::DayOff->value,
					'minutes' => $minutes,
					'way' => 'plus',
				]);
			});
		});

		return self::SUCCESS;
	}
}