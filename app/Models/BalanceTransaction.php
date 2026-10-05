<?php

namespace App\Models;

use App\Enums\RequestTypes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
	'user_id',
	'request_id',
	'type',
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

	public function balance(): BelongsTo
	{
		return $this->belongsTo(Balance::class);
	}

	public function request(): BelongsTo
	{
		return $this->belongsTo(Request::class);
	}

	// Functions
}
