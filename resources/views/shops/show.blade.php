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

		<div class="row gx-5">

			<div class="col-lg-8 pe-0">
			</div>

		</div>
	</div>
@endsection
