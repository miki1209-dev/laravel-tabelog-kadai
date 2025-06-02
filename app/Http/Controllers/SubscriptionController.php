<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
	public function subscribe(Request $request)
	{
		$user = Auth::user();

		try {
			/** @var \App\Models\User|\Laravel\Cashier\Billable $user */
			return $user->newSubscription('premium', env('STRIPE_PRICE_ID'))->checkout([
				'success_url' => route('subscription.success'),
				'cancel_url' => route('subscription.cancel'),
			]);
		} catch (IncompletePayment $e) {
			Log::warning('支払いが未完了です', [
				'user_id' => $user->id,
				'payment_id' => $e->payment->id,
				'message' => $e->getMessage(),
			]);

			return redirect()->route('cashier.payment', $e->payment->id);
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
