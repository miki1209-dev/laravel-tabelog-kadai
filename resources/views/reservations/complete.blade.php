@extends('layouts.app')
@section('content')
	<div class="d-flex justify-content-center align-items-center">
		<div class="col-lg-6 p-5 text-center">
			<h3 class="fw-bold mb-4">ご予約ありがとうございます！</h3>
			<p class="mb-4 text-muted">予約が正常に完了しました。</p>

			<div class="d-flex justify-content-center gap-3">
				<a href="{{ route('top') }}" class="button button--base w-25">トップページへ</a>
				<a href="{{ route('mypage.reservations') }}" class="button button--base w-25">予約一覧へ</a>
			</div>
		</div>
	</div>
@endsection
