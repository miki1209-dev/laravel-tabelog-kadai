@extends('layouts.app')
@section('content')
	<div class="container pt-5">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{ route('mypage') }}">マイページ</a></li>
						<li class="breadcrumb-item active" aria-current="page">有料会員登録</li>
					</ol>
				</nav>

				<div class="mb-4">
					<h3 class="fw-bold">有料会員登録</h3>
				</div>

				<hr class="my-4">

			</div>
		</div>
	</div>
@endsection
