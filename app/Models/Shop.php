<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
	use HasFactory;

	/**
	 * @property \Illuminate\Database\Eloquent\Collection $categories
	 */

	public function categories()
	{
		return $this->belongsToMany(Category::class, 'category_shop');
	}
}
