<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

#[Fillable([
	'gender',
	'first_name',
	'last_name',
	'email',
	'slug',
	'password',
	'birthday',
	'phone',
	'mobile',
	'values',
	'service_id',
	'manager_id',
	'contract_type_id',
	'work_schedule_id',
	'last_logon'
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
	use HasRoles, HasSlug, Notifiable, SoftDeletes;

	/**
	 * Get the attributes that should be cast.
	 *
	 * @return array<string, string>
	 */
	protected function casts(): array
	{
		return [
			'values' => AsCollection::class,
			'birthday' => 'date',
			'password' => 'hashed',
			'last_logon' => 'datetime',
			'created_at' => 'datetime',
			'updated_at' => 'datetime',
			'deleted_at' => 'datetime'
		];
	}

	// Tools
	/**
	 * Get the options for generating the slug.
	 *
	 * @return SlugOptions
	 */
	public function getSlugOptions() : SlugOptions
	{
		return SlugOptions::create()
			->saveSlugsTo('slug')
			->generateSlugsFrom(['first_name', 'last_name']);
	}

	protected function fullName(): Attribute
	{
		return Attribute::make(
			get: fn() => "{$this->first_name} {$this->last_name}",
		);
	}

	// Relations
	public function contractType(): BelongsTo
	{
		return $this->belongsTo(ContractType::class);
	}

	public function manager(): BelongsTo
	{
		return $this->belongsTo(User::class, 'manager_id');
	}

	public function managedService(): HasOne
	{
		return $this->hasOne(Service::class, 'manager_id');
	}

	public function service(): BelongsTo
	{
		return $this->belongsTo(Service::class);
	}

	public function times(): HasMany
	{
		return $this->hasMany(Time::class);
	}

	public function users(): HasMany
	{
		return $this->hasMany(User::class, 'manager_id');
	}

	public function workSchedule(): BelongsTo
	{
		return $this->belongsTo(WorkSchedule::class);
	}

	public function workScheduleType(): BelongsTo
	{
		return $this->belongsTo(WorkScheduleType::class);
	}

	// Functions
	public function timesOfWeek(?int $weekNumber = null, ?int $year = null): Collection
	{
		$date = Carbon::now();

		if ($weekNumber) {
			if ($year) $date->setISODate($year, $weekNumber);
			else $date->setISODate($date->year, $week);
		}

		$startOfWeek = $date->startOfWeek();
		$endOfWeek = $date->copy()->endOfWeek();

		return $this->times()
			->whereBetween('date', [$startOfWeek, $endOfWeek])
			->get();
	}

	public function weeklyTimeSummary(?int $weekNumber = null, ?int $year = null): array
	{
		$times = $this->timesOfWeek($weekNumber, $year)
			->sortBy('date');

		$weeklyHours = $this->workSchedule->weekly_hours;

		$expectedMinutes = $weeklyHours !== null
			? $weeklyHours * 60
			: null;

		$dailyExpectedMinutes = $weeklyHours !== null
			? intdiv($expectedMinutes, 5)
			: null;

		$totalMinutes = 0;
		$daily = [];
		$in = null;

		foreach ($times as $time) {
			if ($time->way === 'in') {
				if ($in) {
					$date = $in->date->format('Y-m-d');

					if (!isset($daily[$date])) {
						$daily[$date] = [
							'date' => $in->date,
							'pairs' => [],
							'minutes' => 0,
						];
					}

					$daily[$date]['pairs'][] = [
						'in' => [
							'id' => $in->id,
							'hour' => $in->date->format('H:i'),
							'source' => $in->manager ? 'chef de service' : 'agent',
						],
						'out' => null,
					];

					$daily[$date]['minutes'] += $minutes;

					$totalMinutes += $minutes;
				}

				$in = $time;

				continue;
			}

			if ($time->way === 'out' && $in) {
				$minutes = $in->date->diffInMinutes($time->date);

				$date = $in->date->format('Y-m-d');

				if (!isset($daily[$date])) {
					$daily[$date] = [
						'date' => $in->date,
						'pairs' => [],
						'minutes' => 0,
					];
				}

				$daily[$date]['pairs'][] = [
					'in' => [
						'id' => $in->id,
						'hour' => $in->date->format('H:i'),
						'source' => $in->manager ? 'chef de service' : 'agent',
					],
					'out' => [
						'id' => $time->id,
						'hour' => $time->date->format('H:i'),
						'source' => $time->manager ? 'chef de service' : 'agent',
					],
				];

				$daily[$date]['minutes'] += $minutes;

				$totalMinutes += $minutes;

				$in = null;
			}
		}

		if ($in) {
			$date = $in->date->format('Y-m-d');

			if (!isset($daily[$date])) {
				$daily[$date] = [
					'date' => $in->date,
					'pairs' => [],
					'minutes' => 0,
				];
			}

			$daily[$date]['pairs'][] = [
				'in' => [
					'id' => $in->id,
					'hour' => $in->date->format('H:i'),
					'source' => $in->manager ? 'chef de service' : 'agent',
				],
				'out' => null,
			];

			$daily[$date]['minutes'] += $minutes;

			$totalMinutes += $minutes;
		}

		foreach ($daily as &$day) {
			$day['difference'] = $dailyExpectedMinutes !== null
				? $day['minutes'] - $dailyExpectedMinutes
				: null;
		}

		unset($day);

		return [
			'days' => array_values($daily),
			'total' => $totalMinutes,
			'expected' => $expectedMinutes,
			'difference' => $expectedMinutes !== null
				? $totalMinutes - $expectedMinutes
				: null,
			'is_hourly' => $weeklyHours !== null,
		];
	}
}
