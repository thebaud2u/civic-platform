<?php

namespace App\Console\Commands;

use App\Enums\AbsenceType;
use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

#[Signature('app:update-recovery-balances')]
#[Description('Update users recovery balances every day')]
class UpdateRecoveryBalances extends Command
{
	public function handle(): int
	{
		$users = User::all();

		foreach ($users as $user) {
			$balance = $user->recoveryBalance;

			if (!$balance) {
				continue;
			}

			$day = $user->times()
				->latest('date')
				->first();

			if (!$day) {
				continue;
			}

			if (
				$balance->transactions()
					->whereDate('date', $day->date)
					->exists()
			) {
				continue;
			}

			$difference = $user->timeOfDay($day->date);

			if ($difference === null || $difference === 0) {
				continue;
			}

			DB::transaction(function () use ($balance, $difference, $day, $user) {
				$balance->increment('minutes', $difference);

				$balance->transactions()->create([
					'user_id' => $user->id,
					'type' => AbsenceType::Recovery->value,
					'date' => $day->date,
					'minutes' => abs($difference),
					'way' => $difference > 0 ? 'plus' : 'minus',
				]);
			});
		}

		return self::SUCCESS;
	}
}