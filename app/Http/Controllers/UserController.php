<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Reservation;
use Illuminate\Support\Carbon;

class UserController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function mypage()
	{
		return view('users.mypage');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit()
	{
		$user = Auth::user();
		return view('users.edit', compact('user'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{

		/** @var \App\Models\User $user */
		$user = Auth::user();

		$request->validate([
			'name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
			'postal_code' => ['nullable', 'regex:/^\d{7}$|^\d{3}-\d{4}$/'],
			'address' => ['nullable', 'string', 'max:255'],
			'phone' => ['nullable', 'regex:/^(0\d{9,10}|0\d{1,4}-\d{1,4}-\d{4})$/'],
		]);

		try {
			$user->name = $request->input('name') ? $request->input('name') : $user->name;
			$user->email = $request->input('email') ? $request->input('email') : $user->email;
			$user->postal_code = $request->input('postal_code') ? $request->input('postal_code') : null;
			$user->address = $request->input('address') ? $request->input('address') : null;
			$user->phone = $request->input('phone') ? $request->input('phone') : null;
			$user->save();

			return redirect()->route('mypage.edit');
		} catch (QueryException $e) {
			// DBへの登録でエラーが出た場合（制約違反とか）、ログの出力先は（storage/logs/laravel.log）で「Database Error」確認してください
			Log::error('Database Error' . $e->getMessage());
			return back()->withErrors(['db_error' => 'データベースへの登録が失敗しました。時間をおいて再度試してみてください'])->withInput();
		} catch (Exception $e) {
			// 予期せぬエラーが出た場合（ネットワーク関連とか）、ログの出力先は（storage/logs/laravel.log）で「General Error」確認してください
			Log::error('General Error' . $e->getMessage());
			return back()->withErrors(['general_error' => '予期せぬエラーが発生しました'])->withInput();
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request)
	{
		/** @var \App\Models\User $user */
		$user = Auth::user();
		$user->delete();
		return redirect()->route('top');
	}

	public function reservations()
	{
		$now = Carbon::now();
		$reservations = Reservation::with('shop')->where('user_id', Auth::user()->id)->where('status', '!=', 'canceled')
			->where(function ($q) use ($now) {
				$q->where('visit_date', '>', $now->toDateString())
					->orWhere(function ($query) use ($now) {
						$query->where('visit_date', $now->toDateString())
							->where('visit_time', '>=', $now->format('H:i:s'));
					});
			})->orderBy('visit_date', 'asc')->paginate(5);

		return view('users.reservations', compact('reservations'));
	}

	public function cancelReservation(Reservation $reservation)
	{
		if ($reservation->user_id !== Auth::id()) {
			return back()->with('error', '権限のない予約です');
		}

		if ($reservation->status === 'canceled') {
			return back()->with('error', 'すでにキャンセル済みの予約です。');
		}

		try {
			$reservation->status = 'canceled';
			$reservation->save();
			return redirect()->route('mypage.reservations');
		} catch (QueryException $e) {
			Log::error('Database Error' . $e->getMessage());
			return back()->withErrors(['db_error' => 'データベースへの登録が失敗しました。時間をおいて再度試してみてください'])->withInput();
		} catch (Exception $e) {
			Log::error('General Error' . $e->getMessage());
			return back()->withErrors(['general_error' => '予期せぬエラーが発生しました'])->withInput();
		}
	}

	public function favorites()
	{
		$user = Auth::user();
		$favorites_shops = $user->favorite_shops()->paginate(5);
		return view('users.favorites', compact('favorites_shops'));
	}

	public function subscription()
	{
		$user = Auth::user();
		return view('users.subscription', compact('user'));
	}
}
