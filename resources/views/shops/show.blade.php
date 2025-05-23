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
				<div class="col-md-5">
					<img src="{{ asset('uploads/' . $shop->file_name) }}" class="img-fluid rounded shadow-sm" alt="店舗画像">
				</div>
				<div class="col-md-7">
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

			<div class="row">
				<h3 class="fw-bold mb-0">カスタマーレビュー</h3>
			</div>

			<div class="review-section row">
				<div class="review-form col-md-4 pe-0">
					<form action="{{ route('reviews.store') }}" method="POST" class="review-form__form"
						onkeydown="return event.key !== 'Enter' || event.target.tagName === 'TEXTAREA';">
						@csrf
						<div class="review-form__group mb-3">
							<label class="review-form__label fw-bold mb-2">評価</label>
							<select name="score" class="review-form__select form-control form-select shadow-sm">
								<option value="5">★★★★★</option>
								<option value="4">★★★★</option>
								<option value="3">★★★</option>
								<option value="2">★★</option>
								<option value="1">★</option>
							</select>
						</div>
						<div class="review-form__group mb-3">
							<label class="review-form__label fw-bold mb-2">タイトル</label>
							<input type="text" name="title" class="review-form__input form-control shadow-sm">
						</div>
						<div class="review-form__group mb-5">
							<label class="review-form__label fw-bold mb-2">レビュー内容</label>
							<textarea name="content" class="review-form__textarea form-control shadow-sm" rows="7"></textarea>
						</div>
						<input type="hidden" name="shop_id" value="{{ $shop->id }}">
						<button type="submit" class="review-form__submit button button--base w-100 shadow-sm">レビューを投稿</button>
					</form>
				</div>
				<div class="col-md-8 ps-0">
					<div class="review-list">
						@foreach ($reviews as $review)
							<div class="review-card p-3 shadow-sm mb-4">
								<div class="review-card__header d-flex justify-content-between align-items-center mb-2">
									<h5 class="review-card__title fw-bold mb-0">{{ $review->title }}</h5>
									<small class="review-card__date text-muted">投稿日：{{ $review->created_at->format('Y年m月d日') }}</small>
								</div>
								<p class="review-card__score mb-2">{{ str_repeat('★', $review->score) }}</p>
								<p class="review-card__content mb-2">{{ $review->content }}</p>
								<p class="review-card__author text-end text-muted mb-0">投稿者：{{ $review->user->name }}</p>
								<div class="review-card__button">
									<button type="submit" class="button button--base">編集</button>
									<button type="submit" class="button button--danger">削除</button>
								</div>
							</div>
						@endforeach
					</div>
					<div class="review-pagination text-center mt-4">
						{{ $reviews->links() }}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
