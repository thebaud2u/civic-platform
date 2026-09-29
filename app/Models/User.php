<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
	/** @use HasFactory<UserFactory> */
	use HasFactory, HasRoles, HasSlug, Notifiable, SoftDeletes;

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

	public function workSchedule(): BelongsTo
	{
		return $this->belongsTo(WorkSchedule::class);
	}
}
