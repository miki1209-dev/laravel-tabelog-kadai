<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
	public function store(Request $request)
	{

		$request->validate([
			'stripeToken' => 'required|string',
			'card_name' => 'required|string|max:255'
		]);

		/** @var \App\Models\User $user */
		$user = Auth::user();

		try {
			$user->createOrGetStripeCustomer(['name' => $request->input('card_name')]);
			$user->updateDefaultPaymentMethod($request->input('stripeToken'));
			$user->newSubscription('default', config('cashier.plan_id'))->create($request->input('stripeToken'));

			return redirect()->route('mypage')->with('status', '有料会員登録が完了しました。');
		} catch (Exception $e) {
			Log::error('Payment Error' . $e->getMessage());
			return back()->withErrors(['stripe_error' => 'サブスクリプション登録に失敗しました。']);
		}
	}

	public function success()
	{
		return view('subscription.success');
	}

	public function cancel()
	{
		return view('subscription.cancel');
	}
}
