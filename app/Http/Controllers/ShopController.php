<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Category;

class ShopController extends Controller
{
	public function index(Request $request)
	{
		$keyword = $request->input('keyword');
		$category = $request->input('category');

		$query = Shop::query();

		if (!empty($keyword)) {
			$query->where(function ($q) use ($keyword) {
				$q->where('name', 'like', "%{$keyword}%")->orWhereHas('categories', function ($q2) use ($keyword) {
					$q2->where('name', 'like', "%{$keyword}%");
				});
			});
		}

		if (!empty($category)) {
			$query->whereHas('categories', function ($q) use ($category) {
				$q->where('name', $category);
			});
		}

		$shops = $query->with('categories')->get();
		$shop_count = $shops->count();

		$categories = Category::all();

		return view('shops.index', compact('keyword', 'shops', 'shop_count', 'category', 'categories'));
	}

	public function show(Shop $shop)
	{
		$reviews = $shop->reviews()->latest()->paginate(5);
		return view('shops/show', compact('shop', 'reviews'));
	}
}
