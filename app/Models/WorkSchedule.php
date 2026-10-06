<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
	'name', 'weekly_hours'
])]
class WorkSchedule extends Model
{
	/**
	 * Get the attributes that should be cast.
	 *
	 * @return array<string, string>
	 */
	protected function casts(): array
	{
		return [
			'created_at' => 'datetime',
			'updated_at' => 'datetime',
			'deleted_at' => 'datetime'
		];
	}

	// Tools

	// Relations
	public function users(): HasMany
	{
		return $this->hasMany(User::class, 'work_schedule_id');
	}

	// Functions
	public function dailyMinutes(): int
	{
		return $this->weekly_hours !== null
			? (int) round($this->weekly_hours / 5 * 60)
			: 420;
	}

	public function formatMinutes(int $minutes): string
	{
		$sign = $minutes < 0 ? '-' : '';
		$minutes = abs($minutes);

		$daily = $this->dailyMinutes();
		$days = intdiv($minutes, $daily);
		$rest = $minutes % $daily;

		return $sign . trim(sprintf('%dj %dh%02d', $days, intdiv($rest, 60), $rest % 60));
	}
}
