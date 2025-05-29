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
			<div class="w-25">
				<h3 class="fw-bold mb-3">キーワードで探す</h3>
				<form action="{{ route('shops.index') }}" method="GET" class="mb-0 shadow-sm">
					<div class="d-flex input-group mt-3">
						<input type="text" placeholder="店舗名・カテゴリで検索" name="keyword" class="form-control">
						<button type="submit"class="button button--base">検索</button>
					</div>
				</form>
			</div>
		</div>

	</div>
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="mb-5">
					<h3 class="fw-bold mb-3">おすすめの店舗</h3>
					<div class="row row-cols-1 row-cols-md-4 g-4">
						@foreach ($recommend_shops as $recommend_shop)
							<div class="col">
								<a href="#">
									<div class="card shadow-sm">
										<img src="{{ asset('uploads/' . $recommend_shop->file_name) }}" class="card-img-top">
										<div class="card-body">
											<h5 class="card-title fw-bold">{{ $recommend_shop->name }}</h5>
											{{-- ここにスコア載せたいなぁ --}}
										</div>
									</div>
								</a>
							</div>
						@endforeach
					</div>
				</div>
				<div class="mb-5">
					<h3 class="fw-bold mb-3">カテゴリで探す</h3>
					<div class="row row-cols-1 row-cols-md-6 g-4 mb-3">
						@foreach ($attentions as $attention)
							<div class="col">
								<a href="#">
									<div class="card card--featured shadow-sm">
										<img src="{{ asset('uploads/' . $attention->file_name) }}" class="card__image card-img-top">
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
								<div class="btn btn-outline-secondary me-1 mb-2 shadow-sm">
									<a href="#">{{ $category->name }}</a>
								</div>
							@endif
						@endforeach
					</div>
				</div>
				<div class="mb-5">
					<h3 class="fw-bold mb-3">新着店舗</h3>
					<div class="row row-cols-1 row-cols-md-4 g-4">
						@foreach ($recently_stores as $recently_store)
							<div class="col">
								<a href="#">
									<div class="card shadow-sm">
										<img src="{{ asset('uploads/' . $recently_store->file_name) }}" class="card-img-top">
										<div class="card-body">
											<h5 class="card-title fw-bold">{{ $recently_store->name }}</h5>
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
