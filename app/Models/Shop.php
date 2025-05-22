<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Review;

class Shop extends Model
{
	use HasFactory;

	protected $fillable = [
		'name',
		'address',
		'phone_number',
		'description',
		'opening_time',
		'closing_time',
		'file_name',
		'recommend_flag'
	];

	/**
	 * @property \Illuminate\Database\Eloquent\Collection $categories
	 */

	public function categories()
	{
		return $this->belongsToMany(Category::class, 'category_shop');
	}

	public function favoredByUsers()
	{
		return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
	}

	public function reviews()
	{
		return $this->hasMany(Review::class);
	}
}
