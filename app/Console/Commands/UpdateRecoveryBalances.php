<?php

namespace App\Console\Commands;

use App\Enums\RequestTypes;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:update-recovery-balances')]
#[Description('Update users recovery balances every day')]
class UpdateRecoveryBalances extends Command
{
	/**
	 * Execute the console command.
	 */
	public function handle()
	{
		$users = User::all();

		if($users->isNotEmpty()) {
			foreach($users as $user) {
				$day = $user->times()
					->latest('created_at')
					->first();

				if (!$day) {
					continue;
				}

				$difference = $user->timeOfDay($day->date);

				if ($difference === null || $difference === 0) {
					continue;
				}

				$balance = $user->recoveryBalance();

				if (!$balance) {
					continue;
				}

				$balance->increment('minutes', $difference);

				$balance->transactions()->create([
					'user_id' => $user->id,
					'type' => RequestTypes::Recovery->value,
					'minutes' => abs($difference),
					'way' => $difference > 0 ? 'plus' : 'minus',
				]);
			}
		}

		return self::SUCCESS;
	}
}
