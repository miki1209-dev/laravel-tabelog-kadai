<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Shop;

class FavoriteController extends Controller
{
	public function store(Shop $shop)
	{
		$user = Auth::user();
		$user->favoriteShops()->attach($shop->id);

		return back();
	}

	public function destroy(Shop $shop)
	{
		$user = Auth::user();
		$user->favoriteShops()->detach($shop->id);

		return back();
	}
}
