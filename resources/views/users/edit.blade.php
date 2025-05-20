@extends('layouts.app')
@section('content')
	<div class="container pt-5 pb-5">
		<div class="row justify-content-center">
			<div class="col-lg-7">
				@if (session('flash_message'))
					<div class="alert alert-light">
						{{ session('flash_message') }}
					</div>
				@endif
				@if ($errors->has('db_error') || $errors->has('general_error'))
					<div class="alert alert-light">
						{{ $errors->first('db_error') ?? $errors->first('general_error') }}
					</div>
				@endif
				<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{ route('mypage') }}">マイページ</a></li>
						<li class="breadcrumb-item active" aria-current="page">会員情報編集</li>
					</ol>
				</nav>

				<div class="mb-4">
					<h3 class="fw-bold">会員情報編集</h3>
				</div>

				<hr class="mb-4">

				<form action="{{ route('mypage.update') }}" method="POST">
					@csrf
					{{-- PATCH --}}
					@method('PUT')
					<div class="mb-3">
						<label for="name" class="form-label">名前<span
								class="ms-2 form-label__indicator form-label__indicator__required">必須</span></label>
						<input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror"
							value="{{ $user->name }}" autocomplete="name">
						@error('name')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>
					<div class="mb-3">
						<label for="email" class="form-label">メールアドレス<span
								class="ms-2 form-label__indicator form-label__indicator__required">必須</span></label>
						<input id="email" type="text" name="email" class="form-control @error('email') is-invalid @enderror"
							value="{{ $user->email }}">
						@error('email')
							<span class="invalid-feedback">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>
					<div class="mb-3">
						<label for="postal_code" class="form-label">郵便番号</label>
						<input id="postal_code" type="text" name="postal_code"
							class="form-control @error('postal_code') is-invalid @enderror" value="{{ $user->postal_code }}">
						@error('postal_code')
							<span class="invalid-feedback">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>
					<div class="mb-3">
						<label for="address" class="form-label">住所</label>
						<input id="address" type="text" name="address" class="form-control @error('address') is-invalid @enderror"
							value="{{ $user->address }}">
						@error('address')
							<span class="invalid-feedback">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>
					<div class="mb-4">
						<label for="phone" class="form-label">電話番号</label>
						<input id="phone" type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
							value="{{ $user->phone }}">
						@error('phone')
							<span class="invalid-feedback">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>
					<div class="d-flex justify-content-center">
						<button type="submit" class="button button--create w-50">更新</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
