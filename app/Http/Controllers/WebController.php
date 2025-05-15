<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Category;

class WebController extends Controller
{
	public function index()
	{
		$shops = Shop::all();
		$recommend_shops = Shop::where('recommend_flag', true)->take(4)->get();
		$recently_stores = Shop::orderBy('created_at', 'desc')->take(4)->get();
		$categories = Category::all();
		$attentions = Category::where('is_featured', true)->take(6)->get();
		return view('web.index', compact('shops', 'recommend_shops', 'recently_stores', 'categories', 'attentions'));
	}
}
