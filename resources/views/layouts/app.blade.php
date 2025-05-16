<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ config('app.name', 'Laravel') }}</title>
	{{-- Bootstrap --}}
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
	{{-- <link rel="stylesheet" href="{{ asset('css/ecmart.css') }}"> --}}
	<!-- Viteの読み込み -->
	@vite(['resources/css/style.scss', 'resources/js/app.js'])
	<!-- Font Awesome -->
	<script src="https://kit.fontawesome.com/1843201c14.js" crossorigin="anonymous"></script>
</head>

<body>
	<div id="app" class="d-flex flex-column min-vh-100">
		@component('components.header')
		@endcomponent
		<main class="flex-grow-1">
			@yield('content')
		</main>
		@component('components.footer')
		@endcomponent
	</div>
	<!-- Bootstrap Scripts -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
	</script>
</body>

</html>
