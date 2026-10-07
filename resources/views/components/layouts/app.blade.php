@props(['title' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>
		{{ config('app.name') }}
	</title>

	<!-- Fonts -->
	<link rel="preconnect" href="https://fonts.bunny.net">
	<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

	<!-- Scripts -->
	@vite(['resources/css/app.css', 'resources/js/app.js'])
	@livewireStyles
</head>

<body class="flex min-h-screen flex-col bg-gray-50 text-gray-900 antialiased">
	<a href="#contenu" class="sr-only focus:not-sr-only focus:absolute focus:left-2 focus:top-2 focus:z-50 focus:rounded focus:bg-white focus:px-3 focus:py-2 focus:text-sm focus:shadow">
		Aller au contenu
	</a>

	{{-- Header --}}
	<header class="border-b border-gray-200 bg-white">
		<div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
			{{-- Logo --}}
			<a href="{{ route('dashboard') }}" class="rounded text-xl font-semibold tracking-tight text-gray-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">
				{{ config('app.name') }}
			</a>

			{{-- User / Logout --}}
			<div class="flex items-center gap-2">
				@can('backoffice.access')
					<x-primary-button :href="route('back-office.dashboard')">
						Back-office
					</x-primary-button>
				@endcan

				<x-primary-button :href="route('account.edit')">
					Mon compte
				</x-primary-button>

				<form action="{{ route('logout') }}" method="POST">
					@csrf

					<x-cancel-button type="submit" :title="'Se déconnecter'" />
				</form>
			</div>
		</div>

		<nav x-data="{ open: false }" @keydown.escape.window="open = false" aria-label="Navigation principale" class="bg-white border-b border-gray-100">
			<!-- Primary Navigation Menu -->
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="flex justify-between h-16">
					<div class="flex">
						<!-- Navigation Links -->
						<div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
							{{-- Dashboard --}}
							<x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
								<svg
									xmlns="http://www.w3.org/2000/svg"
									fill="none"
									viewBox="0 0 24 24"
									stroke-width="1.5"
									stroke="currentColor"
									class="size-5"
									aria-hidden="true"
								>
									<path
										stroke-linecap="round"
										stroke-linejoin="round"
										d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125 1.125 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
									/>
								</svg>

								<span>
									Tableau de bord
								</span>
							</x-nav-link>

							{{-- Requests --}}
							<x-nav-link :href="route('absences')" :active="request()->routeIs('absences')">
								<svg
									xmlns="http://www.w3.org/2000/svg"
									fill="none"
									viewBox="0 0 24 24"
									stroke-width="1.5"
									stroke="currentColor"
									class="size-5"
									aria-hidden="true"
								>
									<path
										stroke-linecap="round"
										stroke-linejoin="round"
										d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"
									/>
								</svg>

								Demandes
							</x-nav-link>
						</div>
					</div>

					<!-- Hamburger -->
					<div class="-me-2 flex items-center sm:hidden">
						<button
							type="button"
							@click="open = ! open"
							aria-label="Menu principal"
							aria-controls="mobile-menu"
							:aria-expanded="open.toString()"
							class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 transition duration-150 ease-in-out"
						>
							<svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24" aria-hidden="true">
								<path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
								<path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
							</svg>
						</button>
					</div>
				</div>
			</div>

			<!-- Responsive Navigation Menu -->
			<div id="mobile-menu" :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
				<div class="pt-2 pb-3 space-y-1">
					{{-- Dashboard --}}
					<x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
						<svg
							xmlns="http://www.w3.org/2000/svg"
							fill="none"
							viewBox="0 0 24 24"
							stroke-width="1.5"
							stroke="currentColor"
							class="size-5"
							aria-hidden="true"
						>
							<path
								stroke-linecap="round"
								stroke-linejoin="round"
								d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125 1.125 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
							/>
						</svg>

						Tableau de bord
					</x-responsive-nav-link>

					{{-- Requests --}}
					<x-responsive-nav-link :href="route('absences')" :active="request()->routeIs('absences')">
						<svg
							xmlns="http://www.w3.org/2000/svg"
							fill="none"
							viewBox="0 0 24 24"
							stroke-width="1.5"
							stroke="currentColor"
							class="size-5"
						>
							<path
								stroke-linecap="round"
								stroke-linejoin="round"
								d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"
							/>
						</svg>

						Demandes
					</x-responsive-nav-link>
				</div>
			</div>
		</nav>
	</header>

	{{-- Main --}}
	<main id="contenu" tabindex="-1" class="flex-1 focus:outline-none">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			@isset($header)
				<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4 p-6">
					{{ $header }}
				</div>
			@endisset

			<div class="py-6">
				{{ $slot }}
			</div>
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