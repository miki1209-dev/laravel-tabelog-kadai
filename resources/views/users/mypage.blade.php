@extends('layouts.app')
@section('content')
	<div class="container pt-5 pb-5">
		<div class="row justify-content-center">
			<div class="col-lg-8">
				@if (session('success'))
					<div class="flash-message flash-message--success">
						<i class="fas fa-check-circle"></i>
						<span>{{ session('success') }}</span>
					</div>
				@endif

				@if ($errors->any())
					<div class="flash-message flash-message--error">
						<i class="fas fa-exclamation-triangle"></i>
						<span>{{ $errors->first() }}</span>
					</div>
				@endif
				<div class="mb-4">
					<div class="d-flex align-items-center justify-content-between">
						<h3 class="fw-bold mb-0">マイページ</h3>
						@if ($user->subscribed('premium'))
							<div>
								現在のステータス：
								<strong>有料会員</strong><br>
								@if ($subscriptionEndDays)
									<small>{{ $subscriptionEndDays }}までご利用可能</small>
								@endif
							</div>
						@else
							<div>現在のステータス：<strong>無料会員</strong></div>
						@endif
					</div>
				</div>
				<div class="mypage-menu">
					<div class="mypage-menu__item">
						<a href="{{ route('mypage.edit') }}" class="mypage-menu__link">
							<i class="fas fa-user mypage-menu__icon"></i>
							<div class="mypage-menu__text">会員情報の編集</div>
							<i class="fas fa-chevron-right mypage-menu__chevron"></i>
						</a>
					</div>

					@if (!$user->subscribed('premium'))
						<div class="mypage-menu__item">
							<a href="{{ route('mypage.subscription') }}" class="mypage-menu__link">
								<i class="fas fa-id-card mypage-menu__icon"></i>
								<div class="mypage-menu__text">有料会員登録</div>
								<i class="fas fa-chevron-right mypage-menu__chevron"></i>
							</a>
						</div>
					@else
						@if (is_null($subscription->ends_at))
							<div class="mypage-menu__item">
								<a href="{{ route('subscription.cancel') }}" class="mypage-menu__link"
									onclick="event.preventDefault(); document.getElementById('cancel-form').submit();">
									<i class="fas fa-door-open mypage-menu__icon"></i>
									<span class="mypage-menu__text">解約</span>
									<i class="fas fa-chevron-right mypage-menu__chevron"></i>
								</a>
								<form id="cancel-form" action="{{ route('subscription.cancel') }}" method="POST" style="display: none;">
									@csrf
								</form>
							</div>

							<div class="mypage-menu__item">
								<a href="#" class="mypage-menu__link">
									<i class="fas fa-credit-card mypage-menu__icon"></i>
									<div class="mypage-menu__text">お支払い方法</div>
									<i class="fas fa-chevron-right mypage-menu__chevron"></i>
								</a>
							</div>
						@endif

						<div class="mypage-menu__item">
							<a href="{{ route('mypage.reservations') }}" class="mypage-menu__link">
								<i class="fas fa-calendar-check mypage-menu__icon"></i>
								<div class="mypage-menu__text">予約一覧</div>
								<i class="fas fa-chevron-right mypage-menu__chevron"></i>
							</a>
						</div>

						<div class="mypage-menu__item">
							<a href="{{ route('mypage.favorites') }}" class="mypage-menu__link">
								<i class="fas fa-heart mypage-menu__icon"></i>
								<div class="mypage-menu__text">お気に入り</div>
								<i class="fas fa-chevron-right mypage-menu__chevron"></i>
							</a>
						</div>
					@endif

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
@endsection
