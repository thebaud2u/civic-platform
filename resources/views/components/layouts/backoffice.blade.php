@props(['title' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>
		{{ config('app.name') }} back-office
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
			<a href="{{ route('back-office.dashboard') }}" class="rounded text-xl font-semibold tracking-tight text-gray-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">
				{{ config('app.name') }} back-office
			</a>

			{{-- User / Logout --}}
			<div class="flex items-center gap-4">
				@role(['agent', 'chef de service'])
					<x-primary-button :href="route('login')">
						Intranet
					</x-primary-button>
				@endrole

				<div class="min-w-0 max-w-[9rem] text-right sm:max-w-xs">
					<p class="truncate text-sm font-medium text-gray-900">
						{{ Auth::user()->fullname }}
					</p>

					<p class="truncate text-xs text-gray-500">
						{{ ucfirst(Auth::user()->roles()->first()?->name ?? '—') }}
					</p>
				</div>

				<form action="{{ route('logout') }}" method="POST">
					@csrf

					<button type="submit" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-gray-500 transition hover:bg-red-50 hover:text-red-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5" aria-hidden="true">
							<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
						</svg>

						<span class="sr-only sm:not-sr-only">
							Se déconnecter
						</span>
					</button>
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
							<x-nav-link :href="route('back-office.dashboard')" :active="request()->routeIs('back-office.dashboard')">
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

							{{-- Services --}}
							<x-nav-link :href="route('back-office.services.index')" :active="request()->routeIs('back-office.services.index')">
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
										d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3"
									/>
								</svg>

								<span>
									Services
								</span>
							</x-nav-link>

							{{-- Users --}}
							<x-nav-link :href="route('back-office.users.index')" :active="request()->routeIs('back-office.users.index')">
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
										d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"
									/>
								</svg>

								<span>
									Utilisateurs
								</span>
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
					<x-responsive-nav-link :href="route('back-office.dashboard')" :active="request()->routeIs('back-office.dashboard')">
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
					</x-responsive-nav-link>

					{{-- Services --}}
					<x-responsive-nav-link :href="route('back-office.services.index')" :active="request()->routeIs('back-office.services.index')">
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
								d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3"
							/>
						</svg>

						<span>
							Services
						</span>
					</x-responsive-nav-link>

					{{-- Users --}}
					<x-responsive-nav-link :href="route('back-office.users.index')" :active="request()->routeIs('back-office.users.index')">
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
								d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"
							/>
						</svg>

						<span>
							Utilisateurs
						</span>
					</x-responsive-nav-link>
				</div>
			</div>
		</nav>
	</header>

	{{-- Main --}}
	<main id="contenu" tabindex="-1" class="flex-1 focus:outline-none">
		<div class="mx-auto flex flex-col w-full max-w-7xl items-center justify-center px-4 py-10 sm:px-6 lg:px-8">
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