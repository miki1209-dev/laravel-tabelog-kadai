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
				<div class="review-form col-md-4">
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
							<input type="text" name="title"
								class="review-form__input form-control shadow-sm @error('title') is-invalid @enderror">
							@error('title')
								<span class="invalid-feedback">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>
						<div class="review-form__group mb-5">
							<label class="review-form__label fw-bold mb-2">レビュー内容</label>
							<textarea name="content" class="review-form__textarea form-control shadow-sm @error('content') is-invalid @enderror"
							 rows="7"></textarea>
							@error('content')
								<span class="invalid-feedback">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
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
								<div class="review-card__actions">
									<button type="button" class="button button--sm button--base me-2" data-bs-toggle="modal"
										data-bs-target="#editReviewModal" data-id="{{ $review->id }}" data-title="{{ $review->title }}"
										data-content="{{ $review->content }}" data-score="{{ $review->score }}"
										data-action="{{ route('reviews.update', $review->id) }}">編集</button>
									<form action="{{ route('reviews.destroy', $review->id) }}" method="POST">
										@csrf
										@method('DELETE')
										<button type="submit" class="button button--sm button--danger">削除</button>
									</form>
								</div>
							</div>
						@endforeach
					</div>
					<div class="review-pagination text-center mt-4">
						{{ $reviews->links() }}
					</div>

					<div class="modal fade review-form" id="editReviewModal" tabindex="-1" aria-hidden="true">
						<div class="modal-dialog modal-xl">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title fw-bold" id="exampleModalLabel">カスタマーレビュー更新</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>
								<div class="modal-body">
									<form method="POST" id="edit-review-form">
										@csrf
										@method('PUT')
										<input type="hidden" name="id" id="edit-review-id">

										<div class="mb-3">
											<label for="edit-review-title" class="col-form-label review-form__label fw-bold">評価</label>
											<select id="edit-review-score" name="score"
												class="review-form__select form-control form-select shadow-sm">
												<option value="5">★★★★★</option>
												<option value="4">★★★★</option>
												<option value="3">★★★</option>
												<option value="2">★★</option>
												<option value="1">★</option>
											</select>
										</div>

										<div class="mb-3">
											<label for="edit-review-title" class="col-form-label review-form__label fw-bold">タイトル</label>
											<input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
												id="edit-review-title" value="{{ old('title') }}">
											@error('title')
												<span class="invalid-feedback">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>
										<div class="mb-3">
											<label for="edit-review-content" class="col-form-label review-form__label fw-bold">内容</label>
											<textarea name="content" class="form-control @error('content') is-invalid @enderror" id="edit-review-content"
											 rows="7">{{ old('content') }}</textarea>
											@error('content')
												<span class="invalid-feedback">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>

										<input type="hidden" name="shop_id" value="{{ $shop->id }}">

										<div class="modal-footer">
											<button type="button" class="button button--danger" data-bs-dismiss="modal">閉じる</button>
											<button type="submit" class="button button--base">更新</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
