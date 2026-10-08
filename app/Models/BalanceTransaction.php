<?php

namespace App\Models;

use App\Enums\AbsenceType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
	'absence_id',
	'balance_id',
	'manager_id',
	'type',
	'date',
	'minutes',
	'way'
])]
class BalanceTransaction extends Model
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
			'minutes' => 'integer',
			'created_at' => 'datetime',
			'updated_at' => 'datetime',
			'deleted_at' => 'datetime'
		];
	}

	// Tools


	// Relations
	public function absence(): BelongsTo
	{
		return $this->belongsTo(Absence::class);
	}

	public function balance(): BelongsTo
	{
		return $this->belongsTo(Balance::class);
	}

	public function manager(): BelongsTo
	{
		return $this->belongsTo(User::class, 'id');
	}

	// Functions
}
