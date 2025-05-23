<header>
	<nav class="navbar navbar-expand-md navbar-light shadow-sm h-auto">
		<div class="container">
			<a href="{{ url('/') }}" class="navbar-brand">
				<img src="{{ asset('img/logo.png') }}" class="">
			</a>
			<div class="collapse navbar-collapse">
				<ul class="navbar-nav ms-auto">
					@guest
						<li class="nav-item me-4">
							<a class="nav-link fw-bold" href="{{ route('register') }}">新規登録</a>
						</li>
						<li class="nav-item me-4">
							<a class="nav-link fw-bold" href="{{ route('login') }}">ログイン</a>
						</li>
					@else
						<li class="nav-item">
							<a class="nav-link fw-bold" href="{{ route('mypage') }}">
								<i class="fas fa-user me-2"></i>マイページ
							</a>
						</li>
					@endguest
				</ul>
			</div>
		</div>
	</nav>
</header>
