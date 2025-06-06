@extends('layouts.app')
@section('content')
	<div class="hero">
		<div class="hero__content">
			<h1 class="hero__title">地元が誇るあの味、手軽に探せる。</h1>
			<p class="hero__subtitle">探す、見つける、食べる。名古屋飯の旅をはじめよう。</p>
		</div>
	</div>
	<div class="pt-4 py-4 mb-5">
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<h3 class="fw-bold mb-3">キーワードで探す</h3>
					<form action="{{ route('shops.index') }}" method="GET" class="mb-0 shadow-sm">
						<div class="d-flex input-group mt-3">
							<input type="text" placeholder="店舗名・カテゴリで検索" name="keyword"
								class="form-control form__input form__input--muted">
							<button type="submit"class="button button--base">検索</button>
						</div>
					</form>
				</div>
			</div>
		</div>

	</div>
	<div class="container">
		<div class="mb-5">
			<h3 class="fw-bold mb-3">おすすめの店舗</h3>
			<div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-4">
				@foreach ($featured_shops as $featured_shop)
					<div class="col">
						<a href="{{ route('shops.show', $featured_shop->id) }}">
							<div class="card shadow-sm">
								@if ($featured_shop->file_name !== null)
									<img src="{{ asset('uploads/' . $featured_shop->file_name) }}" class="card-img-top card__img">
								@else
									<img src="{{ asset('img/dummy.png') }}" class="card-img-top">
								@endif
								<div class="card-body">
									<h5 class="fw-bold fs-6 fs-md-5 fs-xl-4">{{ $featured_shop->name }}</h5>
									@if ($featured_shop->rounded_score !== null)
										<div class="d-flex align-items-center">
											<small class="star-rating me-1" data-rate="{{ $featured_shop->rounded_score }}"></small>
											<small class="me-2">{{ $featured_shop->average_score }}</small>
										</div>
									@else
										<small class="text-muted">レビューなし</small>
									@endif
								</div>
							</div>
						</a>
					</div>
				@endforeach
			</div>
		</div>
		<div class="row">
			<div class="col">
				<div class="mb-5">
					<h3 class="fw-bold mb-3">カテゴリで探す</h3>
					<div class="row row-cols-1 row-cols-md-6 g-4 mb-3">
						@foreach ($attentions as $attention)
							<div class="col">
								<a href="{{ route('shops.index', ['category' => $attention->name]) }}">
									<div class="card card--featured shadow-sm">
										@if ($attention->file_name !== null)
											<img src="{{ asset('uploads/' . $attention->file_name) }}" class="card__image card-img-top">
										@else
											<img src="{{ asset('img/dummy.png') }}" class="card__image card-img-top">
										@endif
										<div class="card__body card-body">
											<h5 class="card__title card-title fw-bold">{{ $attention->name }}</h5>
										</div>
									</div>
								</a>
							</div>
						@endforeach
					</div>
					<div>
						@foreach ($categories as $category)
							@if ($category->is_featured === 0)
								<a href="{{ route('shops.index', ['category' => $category->name]) }}">
									<div class="btn btn-outline-secondary me-1 mb-2 shadow-sm">
										<small>{{ $category->name }}</small>
									</div>
								</a>
							@endif
						@endforeach
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<div class="mb-5">
					<h3 class="fw-bold mb-3">新着店舗</h3>
					<div class="row row-cols-1 row-cols-md-4 g-4">
						@foreach ($recently_shops as $recently_store)
							<div class="col">
								<a href="{{ route('shops.show', $recently_store->id) }}">
									<div class="card shadow-sm">
										@if ($recently_store->file_name !== null)
											<img src="{{ asset('uploads/' . $recently_store->file_name) }}" class="card-img-top card__img">
										@else
											<img src="{{ asset('img/dummy.png') }}" class="card-img-top">
										@endif
										<div class="card-body">
											<h5 class="fw-bold">{{ $recently_store->name }}</h5>
											@if ($recently_store->rounded_score !== null)
												<div class="d-flex align-items-center">
													<small class="star-rating me-1" data-rate="{{ $recently_store->rounded_score }}"></small>
													<small class="me-2">{{ $recently_store->average_score }}</small>
												</div>
											@else
												<small class="text-muted">レビューなし</small>
											@endif
										</div>
									</div>
								</a>
							</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
