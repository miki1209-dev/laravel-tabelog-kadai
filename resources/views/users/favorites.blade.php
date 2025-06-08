@extends('layouts.app')
@section('content')
	<div class="container py-4 py-md-5">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
					<ol class="breadcrumb mb-1 mb-md-0">
						<li class="breadcrumb-item"><a href="{{ route('mypage') }}">マイページ</a></li>
						<li class="breadcrumb-item active" aria-current="page">お気に入り一覧</li>
					</ol>
				</nav>

				<div class="mb-2 mb-md-4">
					<h3>お気に入り一覧</h3>
				</div>

				<hr class="my-3 my-md-4">

				@if ($favorites_shops->isEmpty())
					<div class="row">
						<p class="mb-0">お気に入りはまだ追加されていません。</p>
					</div>
				@else
					@foreach ($favorites_shops as $favorite_shop)
						<div class="row align-items-center mb-md-2">
							<div class="col-md-4 mb-2 mb-md-0">
								<a href="{{ route('shops.show', $favorite_shop->id) }}">
									@if ($favorite_shop->file_name !== null)
										<img src="{{ asset('uploads/' . $favorite_shop->file_name) }}" class="img-thumbnail">
									@else
										<img src="{{ asset('img/dummy.png') }}" class="img-thumbnail">
									@endif
								</a>
							</div>
							<div class="col-md-6 mb-2 mb-md-0">
								<h5 class="w-100">
									<a href="{{ route('shops.show', $favorite_shop->id) }}" class="link-dark ">店舗名：{{ $favorite_shop->name }}</a>
								</h5>
								<div>
									<small>住所：{{ $favorite_shop->address }}</small><br>
									<small>電話番号：{{ $favorite_shop->formatted_phone_number }}</small><br>
									<small>営業時間：{{ $favorite_shop->formatted_opening_time }}〜{{ $favorite_shop->formatted_closing_time }}</small>
								</div>
							</div>
							<div class="col-md-2">
								<form id="favorites-destroy-form" action="{{ route('favorite.destroy', $favorite_shop->id) }}" method="POST">
									@csrf
									@method('DELETE')
									<button type="submit" class="button button--base button--danger button--sp">
										削除
									</button>
								</form>
							</div>
						</div>
						<hr class="my-3 my-md-4">
					@endforeach
				@endif

				<div class="mb-4">
					{{ $favorites_shops->links() }}
				</div>
			</div>
		</div>
	</div>
@endsection
