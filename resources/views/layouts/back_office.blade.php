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
	@livewireStyles
</head>

<body class="min-h-screen bg-gray-50 text-gray-900 antialiased">
	{{-- Header --}}
	<header class="border-b border-gray-200 bg-white">
		<div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
			{{-- Logo --}}
			@auth('admin')
				<a href="{{ route('back-office.dashboard') }}" class="text-xl font-semibold tracking-tight text-gray-900">
			@else
				<a href="{{ route('back-office.index') }}" class="text-xl font-semibold tracking-tight text-gray-900">
			@endauth
				{{ config('app.name') }} back office
			</a>

			@auth('admin')
				{{-- Admin / Logout --}}
				<div class="flex items-center gap-4">
					<div class="hidden text-right sm:block">
						<p class="text-sm font-medium text-gray-900">
							{{ Auth::guard('admin')->user()->fullname }}
						</p>

						<p class="text-xs text-gray-500">
							Administrateur
						</p>
					</div>

					<form action="{{ route('back-office.logout') }}" method="POST">
						@csrf

						<button type="submit" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-gray-500 transition hover:bg-red-50 hover:text-red-600">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
								<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
							</svg>

							<span class="hidden sm:inline">
								Se déconnecter
							</span>
						</button>
					</form>
				</div>
			@endauth
		</div>

		@auth('admin')
			<div class="mx-auto flex h-16 max-w-7xl items-center justify-center px-4 sm:px-6 lg:px-8">
				{{-- Navigation --}}
				<div class="flex items-center gap-1">
					{{-- Dashboard --}}
					<a
						href="{{ route('back-office.dashboard') }}"
						class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium transition
						{{
							Route::currentRouteName() === 'back-office.dashboard'
								? 'bg-gray-100 text-gray-900'
								: 'text-gray-500 hover:bg-gray-50 hover:text-gray-900'
						}}"
					>
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
								d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125 1.125 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
							/>
						</svg>

						<span>
							Tableau de bord
						</span>
					</a>

					{{-- Services --}}
					<a
						href="{{ route('back-office.services.index') }}"
						class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium transition
						{{
							Route::currentRouteName() === 'back-office.services.index'
								? 'bg-gray-100 text-gray-900'
								: 'text-gray-500 hover:bg-gray-50 hover:text-gray-900'
						}}"
					>
						<svg
							xmlns="http://www.w3.org/2000/svg"
							fill="none"
							viewBox="0 0 24 24"
							stroke-width="1.5"
							stroke="currentColor"
							class="size-6"
						>
							<path
								stroke-linecap="round"
								stroke-linejoin="round"
								d="M3.75 21h16.5M4.5 21V9.75L12 5.25l7.5 4.5V21M8.25 21v-6h7.5v6M7.5 10.5h.008v.008H7.5V10.5Zm4.5 0h.008v.008H12V10.5Zm4.5 0h.008v.008H16.5V10.5Z"
							/>
						</svg>

						<span>
							Services
						</span>
					</a>

					{{-- Users --}}
					<a
						href="{{ route('back-office.users.index') }}"
						class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium transition
						{{
							Route::currentRouteName() === 'back-office.users.index'
								? 'bg-gray-100 text-gray-900'
								: 'text-gray-500 hover:bg-gray-50 hover:text-gray-900'
						}}"
					>
						<svg
							xmlns="http://www.w3.org/2000/svg"
							fill="none"
							viewBox="0 0 24 24"
							stroke-width="1.5"
							stroke="currentColor"
							class="size-6"
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
					</a>
				</div>
			</div>
		@endauth
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
	@livewireScripts
</body>
</html>