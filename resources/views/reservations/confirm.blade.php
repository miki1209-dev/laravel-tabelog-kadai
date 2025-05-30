@extends('layouts.app')
@section('content')
	<div class="container pt-5 pb-5">
		<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ route('top') }}">ホーム</a></li>
				<li class="breadcrumb-item"><a href="{{ route('shops.index') }}">店舗一覧</a></li>
				<li class="breadcrumb-item"><a href="{{ route('shops.index', $shop->id) }}">店舗詳細</a></li>
				<li class="breadcrumb-item active" aria-current="page">予約内容確認</li>
			</ol>
		</nav>

		<div class="mb-4">
			<h3 class="fw-bold">予約内容確認</h3>
		</div>

		<hr class="mb-4">

		<table class="table reservation-table text-center align-middle mb-4">
			<thead>
				<tr>
					<th scope="col">店舗名</th>
					<th scope="col">来店日</th>
					<th scope="col">来店時間</th>
					<th scope="col">来店人数</th>
					<th scope="col">来店先の電話番号</th>
					<th scope="col">来店先の住所</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>{{ $shop->name }}</td>
					<td>{{ $reservation->formatted_visit_date }}</td>
					<td>{{ $reservation->formatted_visit_time }}</td>
					<td>{{ $reservation->number_of_people }}人</td>
					<td>{{ $shop->formatted_phone_number }}</td>
					<td>{{ $shop->address }}</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="6">
						<div class="d-flex justify-content-end gap-3">
							<form action="{{ route('reservations.store') }}" method="POST">
								@csrf
								<input type="hidden" name="shop_id" value="{{ $reservation->shop_id }}">
								<input type="hidden" name="visit_date" value="{{ $reservation->visit_date }}">
								<input type="hidden" name="visit_time" value="{{ $reservation->visit_time }}">
								<input type="hidden" name="number_of_people" value="{{ $reservation->number_of_people }}">
								<button type="submit" class="button button--base">予約を確定</button>
							</form>

							<a href="{{ route('shops.show', $shop->id) }}" class="button button--base button--danger">
								キャンセル
							</a>
						</div>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
@endsection
