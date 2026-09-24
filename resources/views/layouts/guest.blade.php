<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name') }}</title>

	<link rel="preconnect" href="https://fonts.bunny.net">
	<link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-50 text-gray-900 antialiased">

	{{-- Header --}}
	<header class="border-b border-gray-200 bg-white">
		<div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">

			{{-- Logo --}}
			<a href="{{ url('/') }}" class="text-xl font-semibold tracking-tight text-gray-900">
				{{ config('app.name') }}
			</a>

			{{-- Navigation --}}
			<nav class="flex items-center gap-3">
				@auth
					<a
						href="{{ url('/dashboard') }}"
						class="rounded-md px-3 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-100 hover:text-gray-900"
					>
						Dashboard
					</a>
				@else
					@if(request()->routeIs('register'))
						<a
							href="{{ route('login') }}"
							class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-gray-700"
						>
							Connexion
						</a>
					@elseif(request()->routeIs('login'))
						<a
							href="{{ route('register') }}"
							class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-gray-700"
						>
							Créer un compte
						</a>
					@else
						<a
							href="{{ route('login') }}"
							class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-gray-700"
						>
							Connexion
						</a>

						<a
							href="{{ route('register') }}"
							class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-gray-700"
						>
							Créer un compte
						</a>
					@endif
				@endauth
			</nav>
		</div>
	</header>

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
</body>
</html>