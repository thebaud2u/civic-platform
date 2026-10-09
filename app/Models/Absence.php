<?php

namespace App\Models;

use App\Enums\{AbsencePeriod, AbsenceStatus, AbsenceType};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
	'type',
	'status',
	'user_id',
	'start',
	'start_period',
	'end',
	'end_period'
])]
class Absence extends Model
{
	/**
	 * Get the attributes that should be cast.
	 *
	 * @return array<string, string>
	 */
	protected function casts(): array
	{
		return [
			'type' => AbsenceType::class,
			'status' => AbsenceStatus::class,
			'start_period' => AbsencePeriod::class,
			'end_period' => AbsencePeriod::class,
			'start' => 'date',
			'end' => 'date',
			'created_at' => 'datetime',
			'updated_at' => 'datetime',
			'deleted_at' => 'datetime'
		];
	}

	// Tools

	// Relations
	public function balanceTransaction(): HasOne
	{
		return $this->hasOne(BalanceTransaction::class);
	}

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	// Functions
}
