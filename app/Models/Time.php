<?php

namespace App\Models;

use App\Observers\TimeObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
	'user_id',
	'way',
	'date',
	'manager_id',
])]
#[ObservedBy(TimeObserver::class)]
class Time extends Model
{
	/**
	 * Get the attributes that should be cast.
	 *
	 * @return array<string, string>
	 */
	protected function casts(): array
	{
		return [
			'date' => 'datetime',
			'created_at' => 'datetime',
			'updated_at' => 'datetime',
			'deleted_at' => 'datetime'
		];
	}

	// Tools

	// Relations
	public function manager(): BelongsTo
	{
		return $this->belongsTo(User::class, 'manager_id');
	}

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
}
