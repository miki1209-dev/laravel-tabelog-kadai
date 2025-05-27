<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Shop;
use Illuminate\Support\Carbon;

class ReservationController extends Controller
{
	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'visit_date' => ['required', 'date', 'after:today'],
			'visit_time' => ['required', 'date_format:H:i'],
			'number_of_people' => ['required', 'integer', 'min:1', 'max:15'],
		]);

		if ($validator->fails()) {
			return back()->withErrors($validator, 'reservation')->withInput();
		}

		try {
			$reservation = new Reservation;
			$reservation->user_id = Auth::user()->id;
			$reservation->shop_id = $request->input('shop_id');
			$reservation->visit_date = $request->input('visit_date');
			$reservation->visit_time = $request->input('visit_time');
			$reservation->number_of_people = $request->input('number_of_people');
			$reservation->save();

			return redirect()->route('reservations.complete');
		} catch (QueryException $e) {
			// DBへの登録でエラーが出た場合（制約違反とか）、ログの出力先は（storage/logs/laravel.log）で「Database Error」確認してください
			Log::error('Database Error' . $e->getMessage());
			return back()->withErrors(['database_error' => 'データベースへの登録が失敗しました。時間をおいて再度試してみてください'])->withInput();
		} catch (Exception $e) {
			// 予期せぬエラーが出た場合（ネットワーク関連とか）、ログの出力先は（storage/logs/laravel.log）で「General Error」確認してください
			Log::error('General Error' . $e->getMessage());
			return back()->withErrors(['general_error' => '予期せぬエラーが発生しました'])->withInput();
		}
	}

	public function confirm(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'visit_date' => ['required', 'date', 'after:today'],
			'visit_time' => ['required', 'date_format:H:i'],
			'number_of_people' => ['required', 'integer', 'min:1', 'max:15'],
		]);

		if ($validator->fails()) {
			return back()->withErrors($validator, 'reservation')->withInput();
		}

		$visit_date = $request->input('visit_date');
		$visit_time = $request->input('visit_time');
		$visit_date_text = Carbon::parse($visit_date)->format('Y年m月d日');
		$visit_time_start = Carbon::parse($visit_time)->format('G:i');
		$visit_time_end = Carbon::parse($visit_time)->addHours()->format('G:i');
		$number_of_people = $request->input('number_of_people');
		$shop_id = $request->input('shop_id');
		$shop = Shop::find($shop_id);

		return view('reservations.confirm', compact('visit_date', 'visit_time', 'number_of_people', 'shop', 'visit_date_text', 'visit_time_start', 'visit_time_end', 'shop_id'));
	}

	public function complete()
	{
		return view('reservations.complete');
	}
}
