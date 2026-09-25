<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
			'last_logon' => 'datetime',
			'password' => 'hashed',
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
			->generateSlugsFrom('last_name');
	}

	protected function fullName(): Attribute
	{
		return Attribute::make(
			get: fn() => "{$this->first_name} {$this->last_name}",
		);
	}

	// Relations
	public function manager(): BelongsTo
	{
		return $this->belongsTo(User::class, 'manager_id');
	}

	public function service(): BelongsTo
	{
		return $this->belongsTo(Service::class);
	}
}
