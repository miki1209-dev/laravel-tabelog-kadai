<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Category;

class WebController extends Controller
{
	public function index()
	{
		$shops = Shop::all();
		$recommend_shops = Shop::where('recommend_flag', true)->take(4)->get();
		$recently_shops = Shop::orderBy('created_at', 'desc')->take(4)->get();
		$categories = Category::all();
		$attentions = Category::where('is_featured', true)->take(6)->get();
		$featured_shops = Shop::withAvg('reviews', 'score')->orderBy('reviews_avg_score', 'desc')->take(4)->get();
		return view('web.index', compact('shops', 'featured_shops', 'recommend_shops', 'recently_shops', 'categories', 'attentions'));
	}
}
