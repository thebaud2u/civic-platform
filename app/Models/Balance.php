<?php

namespace App\Models;

use App\Enums\RequestTypes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
	'user_id',
	'type',
	'minutes',
])]
class Balance extends Model
{
	/**
	 * Get the attributes that should be cast.
	 *
	 * @return array<string, string>
	 */
	protected function casts(): array
	{
		return [
			'type' => RequestTypes::class,
			'minutes' => 'integer',
			'created_at' => 'datetime',
			'updated_at' => 'datetime',
			'deleted_at' => 'datetime'
		];
	}

	// Tools


	// Relations
	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function transactions(): HasMany
	{
		return $this->hasMany(BalanceTransaction::class);
	}

	// Functions
}
