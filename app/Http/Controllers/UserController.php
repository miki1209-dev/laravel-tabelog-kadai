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
			'postal_code' => ['nullable', 'string', 'max:10'],
			'address' => ['nullable', 'string', 'max:255'],
			'phone' => ['nullable', 'string', 'max:20'],
		]);

		try {
			$user->name = $request->input('name') ? $request->input('name') : $user->name;
			$user->email = $request->input('email') ? $request->input('email') : $user->email;
			$user->postal_code = $request->input('postal_code') ? $request->input('postal_code') : $user->postal_code;
			$user->address = $request->input('address') ? $request->input('address') : $user->address;
			$user->phone = $request->input('phone') ? $request->input('phone') : $user->phone;
			$user->save();

			return redirect(route('mypage.edit'))->with('flash_message', '会員情報を更新しました。');
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
	public function destroy()
	{
		//退会処理
	}

	public function reservations()
	{
		return view('users.reservations');
	}
}
