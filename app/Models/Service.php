<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

#[Fillable(['name', 'description', 'slug', 'manager_id', 'parent_service_id'])]
class Service extends Model
{
	use SoftDeletes, HasSlug;

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
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
			->generateSlugsFrom('name');
	}

	// Relations
	public function childrenServices(): HasMany
	{
		return $this->hasMany(Service::class, 'parent_service_id');
	}

	public function manager(): BelongsTo
	{
		return $this->belongsTo(User::class, 'manager_id');
	}

	public function parentService(): BelongsTo
	{
		return $this->belongsTo(Service::class, 'parent_service_id');
	}

	public function users(): HasMany
	{
		return $this->hasMany(User::class);
	}
}
