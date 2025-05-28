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
			<div class="row align-items-center">
				<div class="col-md-5">

					<img src="{{ asset('uploads/' . $shop->file_name) }}" class="img-fluid rounded shadow-sm" alt="店舗画像">
				</div>
				<div class="col-md-7">
					<div class="d-flex align-items-center mb-3">
						<h2 class="fw-bold me-3 mb-0">{{ $shop->name }}</h2>
						<div class="row align-items-end">
							<div class="col-md-6">
								@if (Auth::user()->favorite_shops->contains($shop->id))
									<form action="{{ route('favorite.destroy', $shop->id) }}" method="POST">
										@csrf
										@method('DELETE')
										<button type="submit" class="button button--base button--sm">
											<i class="fas fa-heart-broken"></i>
										</button>
									</form>
								@else
									<form action="{{ route('favorite.store', $shop->id) }}" method="POST">
										@csrf
										<button type="submit" class="button button--base button--sm">
											<i class="far fa-heart"></i>
										</button>
									</form>
								@endif
							</div>
						</div>
					</div>
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
						<li class="mb-2">
							<i class="fas fa-calendar-plus me-2 text-secondary"></i>
							<strong>予約は下記のフォームから</strong>
						</li>
					</ul>
					<div class="row align-items-center">
						{{-- // 予約関連ここから --}}

						<div class="col-md-12">
							<form action="{{ route('reservations.confirm') }}" method="POST">
								@csrf
								<input type="hidden" name="shop_id" value="{{ $shop->id }}">
								<div class="row g-3 align-items-end @if (
									$errors->reservation->has('visit_date') ||
										$errors->reservation->has('visit_time') ||
										$errors->reservation->has('number_of_people')) has-validation-error @endif">
									<div class="col-md-3 mt-2">
										<label class="form-label">来店日</label>
										<input type="date" name="visit_date"
											class="form-control @error('visit_date', 'reservation') is-invalid @enderror" min="{{ $tomorrow }}">
										@error('visit_date', 'reservation')
											<span class="invalid-feedback">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
									</div>

									<div class="col-md-3 mt-2 @if (
										$errors->reservation->has('visit_date') ||
											$errors->reservation->has('visit_time') ||
											$errors->reservation->has('number_of_people')) has-validation-error @endif">
										<label class="form-label">来店時間</label>
										<select name="visit_time" class="form-control @error('visit_time', 'reservation') is-invalid @enderror">
											<option value="">選択してください</option>
											@for ($i = $startHour; $i < $endHour; $i++)
												<option value="{{ sprintf('%02d:00', $i) }}">{{ sprintf('%02d:00', $i) }}〜{{ sprintf('%02d:00', $i + 1) }}
												</option>
											@endfor
										</select>
										@error('visit_time', 'reservation')
											<span class="invalid-feedback">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
									</div>

									<div class="col-md-3 mt-2 @if (
										$errors->reservation->has('visit_date') ||
											$errors->reservation->has('visit_time') ||
											$errors->reservation->has('number_of_people')) has-validation-error @endif">
										<label class="form-label">来店人数</label>
										<select name="number_of_people"
											class="form-control @error('number_of_people', 'reservation') is-invalid @enderror">
											<option value="">選択してください</option>
											@for ($i = 1; $i <= 15; $i++)
												<option value="{{ $i }}">{{ $i }}人</option>
											@endfor
										</select>
										@error('number_of_people', 'reservation')
											<span class="invalid-feedback">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
									</div>

									<div class="col-md-3 mt-2 @if (
										$errors->reservation->has('visit_date') ||
											$errors->reservation->has('visit_time') ||
											$errors->reservation->has('number_of_people')) has-validation-error @endif">
										<button type="submit" class="button button--base">
											<i class="fas fa-calendar-plus"></i>
											予約
										</button>
									</div>
								</div>
							</form>
						</div>
						{{-- // 予約関連ここまで --}}
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
								<option value="5" {{ old('score') == 5 ? 'selected' : '' }}>★★★★★</option>
								<option value="4" {{ old('score') == 4 ? 'selected' : '' }}>★★★★</option>
								<option value="3" {{ old('score') == 3 ? 'selected' : '' }}>★★★</option>
								<option value="2" {{ old('score') == 2 ? 'selected' : '' }}>★★</option>
								<option value="1" {{ old('score') == 1 ? 'selected' : '' }}>★</option>
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
								@if (Auth::id() === $review->user_id)
									<div class="review-card__actions">
										<button type="button" class="button button--sm button--base me-2" data-bs-toggle="modal"
											data-bs-target="#editReviewModal" data-id="{{ $review->id }}" data-title="{{ $review->title }}"
											data-content="{{ $review->content }}" data-score="{{ $review->score }}"
											data-action="{{ route('reviews.update', $review->id) }}">編集</button>
										<form action="{{ route('reviews.destroy', $review->id) }}" method="POST"
											onsubmit="return confirm('本当に削除しますか？');">
											@csrf
											@method('DELETE')
											<button type="submit" class="button button--sm button--danger">削除</button>
										</form>
									</div>
								@endif
							</div>
						@endforeach
					</div>
					<div class="review-pagination text-center mt-4">
						{{ $reviews->links() }}
					</div>

					<div class="modal fade review-form" id="editReviewModal"
						data-should-open="{{ session('modal_open') === 'editReviewModal' ? 'true' : 'false' }}" tabindex="-1"
						aria-hidden="true">
						<div class="modal-dialog modal-xl">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title fw-bold" id="exampleModalLabel">カスタマーレビュー更新</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>
								<div class="modal-body">
									<form method="POST" id="edit-review-form" action="{{ session('action') }}">
										@csrf
										@method('PUT')
										<input type="hidden" name="id" id="edit-review-id">

										<div class="mb-3">
											<label for="edit-review-score" class="col-form-label review-form__label fw-bold">評価</label>
											<select id="edit-review-score" name="score"
												class="review-form__select form-control form-select shadow-sm">
												<option value="5" {{ old('score') == 5 ? 'selected' : '' }}>★★★★★</option>
												<option value="4" {{ old('score') == 4 ? 'selected' : '' }}>★★★★</option>
												<option value="3" {{ old('score') == 3 ? 'selected' : '' }}>★★★</option>
												<option value="2" {{ old('score') == 2 ? 'selected' : '' }}>★★</option>
												<option value="1" {{ old('score') == 1 ? 'selected' : '' }}>★</option>
											</select>
										</div>

										<div class="mb-3">
											<label for="edit-review-title" class="col-form-label review-form__label fw-bold">タイトル</label>
											<input type="text" name="title"
												class="form-control review-form__input form-control shadow-sm  @error('title', 'editReview') is-invalid @enderror"
												id="edit-review-title" value="{{ old('title') }}">
											@error('title', 'editReview')
												<span class="invalid-feedback">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>
										<div class="mb-3">
											<label for="edit-review-content" class="col-form-label review-form__label fw-bold">内容</label>
											<textarea name="content" id="edit-review-content"
											 class="form-control review-form__textarea form-control shadow-sm  @error('content', 'editReview') is-invalid @enderror"
											 rows="7">{{ old('content') }}</textarea>
											@error('content', 'editReview')
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
