<?php

namespace App\Models;

use App\Notifications\AdminResetPassword;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

#[Fillable(['first_name', 'last_name', 'email', 'slug', 'password', 'last_logon'])]
#[Hidden(['password', 'remember_token'])]
class Admin extends Authenticatable
{
	use HasRoles, HasSlug, Notifiable, SoftDeletes;

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'password' => 'hashed',
		'last_logon' => 'datetime',
		'created_at' => 'datetime',
		'updated_at' => 'datetime',
		'deleted_at' => 'datetime'
	];

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

	public function sendPasswordResetNotification($token): void
	{
		$this->notify(new AdminResetPassword($token));
	}
}
