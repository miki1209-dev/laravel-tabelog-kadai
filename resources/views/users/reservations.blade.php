@extends('layouts.app')
@section('content')
	<div class="container pt-5 pb-5">
		<div class="row justify-content-center">
			<div class="col-lg-8">
				@if (session('error'))
					<div class="alert alert-danger">{{ session('error') }}</div>
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

				@if ($reservations->isEmpty())
					<div class="row">
						<p class="mb-0">ご予約はされていません。</p>
					</div>
				@else
					@foreach ($reservations as $reservation)
						<div class="row align-items-center mb-2">
							<div class="col-md-4">
								<a href="{{ route('shops.show', $reservation->shop_id) }}">
									@if ($reservation->file_name !== '')
										<img src="{{ asset('uploads/' . $reservation->shop->file_name) }}" class="img-thumbnail">
									@else
										<img src="{{ asset('img/dummy.png') }}" class="img-thumbnail">
									@endif
								</a>
							</div>
							<div class="col-md-6">
								<h5 class="w-100">
									<a href="{{ route('shops.show', $reservation->id) }}" class="link-dark ">店舗名：{{ $reservation->shop->name }}</a>
								</h5>
								<div>
									<small>来店日：{{ $reservation->formatted_visit_date }}</small><br>
									<small>来店時間：{{ $reservation->formatted_visit_time }}</small><br>
									<small>来店人数：{{ $reservation->number_of_people }}人</small><br>
									<small>電話番号：{{ $reservation->shop->formatted_phone_number }}</small><br>
									<small>住所：{{ $reservation->shop->address }}</small>
								</div>
							</div>
							<div class="col-md-2">
								<form action="{{ route('mypage.reservations.cancel', $reservation->id) }}" method="POST"
									onsubmit="return confirm('本当にキャンセルしますか？');">
									@csrf
									@method('PATCH')
									<button type="submit" class="button button--base button--danger">キャンセル</button>
								</form>
							</div>
						</div>
						<hr class="my-4">
					@endforeach
				@endif

				{{ $reservations->links() }}

			</div>
		</div>
	</div>
@endsection
