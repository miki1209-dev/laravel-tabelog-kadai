@extends('layouts.app')
@section('content')
	<div class="container pt-5 pb-5">
		<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ route('top') }}">ホーム</a></li>
				<li class="breadcrumb-item"><a href="{{ route('shops.index') }}">店舗一覧</a></li>
				<li class="breadcrumb-item active" aria-current="page">店舗詳細</li>
			</ol>
		</nav>
		<div class="container px-0">
			<div class="row">
				<div class="col-md-6">
					<img src="{{ asset('uploads/' . $shop->file_name) }}" class="img-fluid rounded shadow-sm" alt="店舗画像">
				</div>
				<div class="col-md-6">
					<!-- 店舗情報（名前、住所など） -->
					<h2 class="fw-bold mb-4">{{ $shop->name }}</h2>
					<ul class="list-unstyled">
						<li class="mb-2">
							<i class="fas fa-map-marker-alt me-2 text-secondary"></i>
							<strong>住所：</strong>{{ $shop->address }}
						</li>
						<li class="mb-2">
							<i class="fas fa-phone-alt me-2 text-secondary"></i>
							<strong>電話番号：</strong>{{ $shop->phone_number }}
						</li>
						<li class="mb-2">
							<i class="fas fa-clock me-2 text-secondary"></i>
							<strong>営業時間：</strong>{{ $shop->opening_time }} ～ {{ $shop->closing_time }}
						</li>
						<li class="mb-2">
							<i class="fas fa-info-circle me-2 text-secondary"></i>
							<strong>説明：</strong>{{ $shop->description }}
						</li>
					</ul>
					<!-- アクションボタン（お気に入り、レビュー） -->
					<div class="mt-4">
						@if (Auth::user()->favoriteShops->contains($shop->id))
							<form action="{{ route('favorite.destroy', $shop->id) }}" method="POST">
								@csrf
								@method('DELETE')
								<button type="submit" class="button button--base w-100">
									<i class="fas fa-heart-broken"></i>
									お気に入り解除
								</button>
							</form>
						@else
							<form action="{{ route('favorite.store', $shop->id) }}" method="POST">
								@csrf
								<button type="submit" class="button button--base w-100">
									<i class="far fa-heart"></i>
									お気に入り登録
								</button>
							</form>
						@endif
					</div>
				</div>
			</div>

			<hr class="my-5">

			<!-- レビュー一覧と投稿フォーム -->
			<div class="mt-5" id="review-form">
				<h3 class="fw-bold mb-3">カスタマーレビュー</h3>
				<p>※レビューはまだありません。</p>
				{{-- またはレビュー表示 --}}
			</div>
		</div>
	</div>
	</div>
@endsection
