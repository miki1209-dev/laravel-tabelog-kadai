@extends('layouts.app')
@section('content')
	<div class="container pt-5 pb-5">
		<div class="row justify-content-center">
			<div class="col-lg-7">
				@if (session('flash_message'))
					<div class="alert alert-light">
						{{ session('flash_message') }}
					</div>
				@endif

				<div class="mb-4">
					<h3 class="fw-bold">マイページ</h3>
				</div>

				<div class="mypage-menu">
					<div class="mypage-menu__item">
						<a href="{{ route('mypage.edit') }}" class="mypage-menu__link">
							<i class="fas fa-user mypage-menu__icon"></i>
							<div class="mypage-menu__text">会員情報の編集</div>
							<i class="fas fa-chevron-right mypage-menu__chevron"></i>
						</a>
					</div>
				</div>

				<div class="mypage-menu">
					<div class="mypage-menu__item">
						<a href="#" class="mypage-menu__link">
							<i class="fas fa-id-card mypage-menu__icon"></i>
							<div class="mypage-menu__text">有料会員登録</div>
							<i class="fas fa-chevron-right mypage-menu__chevron"></i>
						</a>
					</div>
				</div>

				<div class="mypage-menu">
					<div class="mypage-menu__item">
						<a href="#" class="mypage-menu__link">
							<i class="fas fa-door-open mypage-menu__icon"></i>
							<div class="mypage-menu__text">解約</div>
							<i class="fas fa-chevron-right mypage-menu__chevron"></i>
						</a>
					</div>
					<div class="mypage-menu">
						<div class="mypage-menu__item">
							<a href="#" class="mypage-menu__link">
								<i class="fas fa-credit-card mypage-menu__icon"></i>
								<div class="mypage-menu__text">お支払い方法</div>
								<i class="fas fa-chevron-right mypage-menu__chevron"></i>
							</a>
						</div>
					</div>
					<div class="mypage-menu">
						<div class="mypage-menu__item">
							<a href="#" class="mypage-menu__link">
								<i class="fas fa-calendar-check mypage-menu__icon"></i>
								<div class="mypage-menu__text">予約一覧</div>
								<i class="fas fa-chevron-right mypage-menu__chevron"></i>
							</a>
						</div>
					</div>
					<div class="mypage-menu">
						<div class="mypage-menu__item">
							<a href="#" class="mypage-menu__link">
								<i class="fas fa-heart mypage-menu__icon"></i>
								<div class="mypage-menu__text">お気に入り</div>
								<i class="fas fa-chevron-right mypage-menu__chevron"></i>
							</a>
						</div>
					</div>
					<div class="mypage-menu">
						<div class="mypage-menu__item">
							<a href="{{ route('logout') }}" class="mypage-menu__link"
								onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
								<i class="fas fa-sign-out-alt mypage-menu__icon"></i>
								<span class="mypage-menu__text">ログアウト</span>
								<i class="fas fa-chevron-right mypage-menu__chevron"></i>
							</a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								@csrf
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
