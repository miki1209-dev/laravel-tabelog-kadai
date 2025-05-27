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
						<li class="breadcrumb-item active" aria-current="page">予約一覧</li>
					</ol>
				</nav>

				<div class="mb-4">
					<h3 class="fw-bold">予約一覧</h3>
				</div>

				<hr class="mb-4">

			</div>
		</div>
	</div>
@endsection
