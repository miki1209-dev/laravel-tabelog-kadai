<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Support\Facades\Log;


class ReviewController extends Controller
{
	public function store(Request $request)
	{
		$request->validate([
			'title' => 'required|max:20',
			'content' => 'required',
			'score' => 'required|integer|min:1|max:5',
		]);

		try {
			$review = new Review;
			$review->user_id = Auth::user()->id;
			$review->shop_id = $request->input('shop_id');
			$review->title = $request->input('title');
			$review->content = $request->input('content');
			$review->score = $request->input('score');
			$review->save();

			return back();
		} catch (QueryException $e) {
			// DBへの登録でエラーが出た場合（制約違反とか）、ログの出力先は（storage/logs/laravel.log）で「Database Error」確認してください
			Log::error('Database Error' . $e->getMessage());
			return back()->withErrors(['db_error' => 'データベースへの登録が失敗しました。時間をおいて再度試してみてください'])->withInput();
		} catch (Exception $e) {
			Log::error('General Error' . $e->getMessage());
			return back()->withErrors(['general_error' => '予期せぬエラーが発生しました'])->withInput();
		}
	}
}
