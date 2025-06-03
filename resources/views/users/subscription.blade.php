@extends('layouts.app')
@section('content')
	<div class="container pt-5">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{ route('mypage') }}">マイページ</a></li>
						<li class="breadcrumb-item active" aria-current="page">有料会員登録</li>
					</ol>
				</nav>

				<div class="mb-4">
					<h3 class="fw-bold">有料会員登録</h3>
				</div>

				<hr class="my-4">

				<form action="{{ route('subscription.store') }}" method="POST" id="subscription-form" class="form">
					@csrf
					<div class="form__group">
						<label for="cardholder-name" class="form__label mb-1">カード名義人</label>
						<input type="text" id="cardholder-name" name="card_name" class="form-control form__input form__input--muted">
					</div>
					<label for="card-element" class="form__label mb-1">カード情報</label>
					<div class="form__group">
						<div id="card-element"></div>
						<div id="card-errors" class="form__error text-danger mt-1" style="display: none;"></div>
					</div>
					<div class="d-flex justify-content-center">
						<button type="submit" class="button button--base">登録する</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
