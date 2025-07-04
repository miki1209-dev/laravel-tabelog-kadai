@extends('layouts.app')
@section('content')
	<div class="container py-4 py-md-5">
		<div class="row justify-content-center">
			<div class="col-md-8">
				@if (session('success'))
					<div class="flash-message flash-message--success">
						<i class="fas fa-exclamation-triangle"></i>
						<span>{{ session('success') }}</span>
					</div>
				@endif
				@if (session('error'))
					<div class="flash-message flash-message--error">
						<i class="fas fa-exclamation-triangle"></i>
						<span>{{ session('error') }}</span>
					</div>
				@endif
				<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
					<ol class="breadcrumb mb-1 mb-md-2">
						<li class="breadcrumb-item"><a href="{{ route('mypage') }}">マイページ</a></li>
						<li class="breadcrumb-item active" aria-current="page">お支払い方法変更</li>
					</ol>
				</nav>

				<div class="mb-2 mb-md-4">
					<h3>お支払い方法変更</h3>
				</div>

				<hr class="my-3 my-md-4">

				<form action="{{ route('subscription.update') }}" method="POST" id="update-form" class="form">
					@csrf
					<div class="form__group">
						<label for="cardholder-name" class="form__label mb-1">カード名義人</label>
						<input type="text" id="cardholder-name" name="card_name"
							class="form-control form__input form__input--muted mb-1 @error('card_name') is-invalid @enderror"
							value="{{ old('card_name') }}">
						@error('card_name')
							<div class="form__error text-danger mt-1">{{ $message }}</div>
						@enderror
						<div id="name-errors" class="form__error text-danger mt-1" style="display: none;"></div>
					</div>
					<div class="form__group">
						<label for="card-element" class="form__label mb-1">カード情報</label>
						<div id="card-element"></div>
						@if ($defaultPaymentMethod)
							<small>現在のカード番号: **** **** **** {{ $defaultPaymentMethod->card->last4 }}</small>
						@endif
						<div id="card-errors" class="form__error text-danger mt-1" style="display: none;"></div>
						@error('stripeToken')
							<div class="form__error text-danger mt-1">{{ $message }}</div>
						@enderror
					</div>
					<div class="d-flex justify-content-center">
						<button type="submit" class="button button--base">更新する</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
@section('scripts')
	@vite('resources/js/stripe-update.js')
@endsection
