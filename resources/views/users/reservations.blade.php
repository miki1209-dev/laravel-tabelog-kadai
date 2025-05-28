@extends('layouts.app')
@section('content')
	<div class="container pt-5 pb-5">
		<div class="row justify-content-center">
			<div class="col-lg-8">
				@if (session('error'))
					<div class="alert alert-danger">{{ session('error') }}</div>
				@endif

				@if ($errors->has('db_error') || $errors->has('general_error'))
					<div class="alert alert-light">
						{{ $errors->first('db_error') ?? $errors->first('general_error') }}
					</div>
				@endif
				<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{ route('mypage') }}">マイページ</a></li>
						<li class="breadcrumb-item active" aria-current="page">予約一覧</li>
					</ol>
				</nav>

				<div class="mb-4">
					<h3 class="fw-bold">予約一覧</h3>
				</div>

				<hr class="mb-4">

				<table class="table reservation-table align-middle text-center shadow-sm rounded overflow-hidden">
					<thead class="table-header">
						<tr>
							<th scope="col">店舗名</th>
							<th scope="col">来店日</th>
							<th scope="col">来店時間</th>
							<th scope="col">来店人数</th>
							<th scope="col">操作</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($reservations as $reservation)
							<tr>
								<td>{{ $reservation->shop->name }}</td>
								<td>{{ $reservation->visit_date_formatted }}</td>
								<td>{{ $reservation->visit_time_start }}〜{{ $reservation->visit_time_end }}</td>
								<td>{{ $reservation->number_of_people }}人</td>
								<td>
									<form action="{{ route('mypage.reservations.cancel', $reservation->id) }}" method="POST"
										onsubmit="return confirm('本当にキャンセルしますか？');">
										@csrf
										@method('PATCH')
										<button type="submit" class="button button--sm button--danger">キャンセル</button>
									</form>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>

				{{ $reservations->links() }}

			</div>
		</div>
	</div>
@endsection
