@extends('layouts.app')
@section('content')
	<div class="hero">
		<div class="hero__content">
			<h1 class="hero__title">地元が誇るあの味、手軽に探せる。</h1>
			<p class="hero__subtitle">探す、見つける、食べる。名古屋飯の旅をはじめよう。</p>
		</div>
	</div>
	<div class="container ">
		<div class="mb-4 py-4">
			<h2 class="fw-bold mb-0">キーワードで探す</h2>
			<form action="#" method="GET" class="w-25">
				<div class="d-flex input-group mt-3">
					<input type="text" placeholder="キーワードを入力する" name="keyword" class="form-control">
					<button type="submit"class="btn btn-primary">検索</button>
				</div>
			</form>
		</div>
		<div>
			<h2 class="fw-bold mb-0">おすすめの店舗</h2>
			<div class="card">

			</div>
		</div>
	</div>
@endsection
