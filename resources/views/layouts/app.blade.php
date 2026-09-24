<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Fonts -->
	<link rel="preconnect" href="https://fonts.bunny.net">
	<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

	<!-- Scripts -->
	@vite(['resources/css/app.css', 'resources/js/app.js'])
	@livewireStyles
</head>

<body class="min-h-screen bg-gray-50 text-gray-900 antialiased">
	{{-- Main --}}
	<main class="min-h-[calc(100vh-9rem)]">
		<div class="mx-auto flex w-full max-w-7xl justify-center px-4 py-10 sm:px-6 lg:px-8">
			{{ $slot }}
		</div>
	</main>

	{{-- Footer --}}
	<footer class="border-t border-gray-200 bg-white">
		<div class="mx-auto flex h-12 max-w-7xl items-center justify-center px-4 text-sm text-gray-500">
			&copy; {{ date('Y') }} {{ config('app.name') }}
		</div>
	</footer>

	@stack('scripts')
	@livewireScripts
</body>
</html>