@extends('layouts.app')
@section('content')
	<div class="container pt-5 pb-5">
		<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ route('top') }}">ホーム</a></li>
				<li class="breadcrumb-item active" aria-current="page">店舗一覧</li>
			</ol>
		</nav>

		@if ($keyword)
			<h3 class="fw-bold mb-4">{{ $keyword }}の検索結果は{{ number_format($shop_count) }}件です</h3>
		@elseif($category)
			<h3 class="fw-bold mb-4">{{ $category }}の検索結果は{{ number_format($shop_count) }}件です</h3>
		@elseif($keyword === null && $category === null)
			<h3 class="fw-bold mb-4">{{ number_format($shop_count) }}件の店舗が見つかりました</h3>
		@endif

		<div class="row gx-5">

			<div class="col-lg-8 pe-0">
				@foreach ($shops as $shop)
					<div class="d-flex mb-4 align-items-center bg-white rounded shadow-sm p-3">
						<div class="col-lg-4 me-3">
							<a href="{{ route('shops.show', ['shop' => $shop->id] + $queryParams) }}">
								<img src="{{ asset('uploads/' . $shop->file_name) }}" class="img-fluid rounded shadow-sm">
							</a>
						</div>
						<div class="col-lg-8">
							<h5 class="fw-bold">{{ $shop->name }}</h5>
							<div class="mb-2">
								@foreach ($shop->categories as $category)
									<span class="badge bg-secondary me-1">{{ $category->name }}</span>
								@endforeach
							</div>
							{{-- <p class="mb-1">
								<i class="fas fa-info-circle me-2 text-muted"></i>{{ $shop->description }}
							</p> --}}
							<p class="mb-1">
								<i class="fas fa-phone me-2 text-muted"></i>{{ $shop->phone_number }}
							</p>
							<p class="mb-1">
								<i class="fas fa-map-marker-alt me-2 text-muted"></i>{{ $shop->address }}
							</p>
							<p class="mb-0">
								<i class="fas fa-clock me-2 text-muted"></i>{{ $shop->opening_time }}〜{{ $shop->closing_time }}
							</p>
						</div>
					</div>
				@endforeach
			</div>

			<div class="col-lg-4 mt-lg-0 mt-5">
				<div class="px-4 py-4 bg-white rounded shadow-sm">
					<h5 class="fw-bold mb-4 border-bottom pb-2">キーワードで探す</h5>
					<form action="{{ route('shops.index') }}" method="GET" class="mb-4">
						<input type="text" placeholder="店舗名・カテゴリで検索" name="keyword" class="form-control mb-3"
							value="{{ request('keyword') }}">
						<button type="submit" class="button button--base w-100">検索</button>
					</form>

					<h5 class="fw-bold mb-3 border-bottom pb-2">カテゴリで探す</h5>
					<form action="{{ route('shops.index') }}" method="GET">
						<div class="mb-3">
							<select class="form-select" name="category">
								<option value="">カテゴリを選択</option>
								@foreach ($categories as $category)
									<option value="{{ $category->name }}" {{ request('category') === $category->name ? 'selected' : '' }}>
										{{ $category->name }}
									</option>
								@endforeach
							</select>
						</div>
						<button type="submit" class="button button--base w-100">カテゴリ検索</button>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
