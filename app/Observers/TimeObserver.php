<?php

namespace App\Observers;

use App\Enums\AbsenceType;
use App\Models\Time;

class TimeObserver
{
	public function created(Time $time): void
	{
		if ($time->manager) {
			$this->recalculate($time);
		}
	}

	public function deleted(Time $time): void
	{
		if ($time->manager) {
			$this->recalculate($time);
		}
	}

	private function recalculate(Time $time): void
	{
		$user = $time->user;

		$balance = $user->recoveryBalance;

		$balanceTransactions = $balance->transactions()
			->whereDate('date', $time->date);

		if ($balanceTransactions->exists()) {
			foreach ($balanceTransactions->get() as $balanceTransaction) {
				$balance->decrement(
					'minutes',
					$balanceTransaction->way === 'plus'
						? $balanceTransaction->minutes
						: -$balanceTransaction->minutes
				);

				$balanceTransaction->delete();
			}
		}

		$difference = $user->timeOfDay($time->date);

		if ($difference === null || $difference === 0) {
			return;
		}

		$balance->increment('minutes', $difference);

		$balance->transactions()->create([
			'user_id' => $user->id,
			'type' => AbsenceType::Recovery->value,
			'date' => $time->date,
			'minutes' => abs($difference),
			'way' => $difference > 0 ? 'plus' : 'minus',
		]);
	}
}