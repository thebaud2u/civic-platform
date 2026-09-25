<x-backoffice-layout>
	<div class="flex flex-col">
		{{-- Header --}}
		<div class="mb-8">
			<h1 class="text-2xl font-semibold tracking-tight text-gray-900">
				Tableau de bord
			</h1>

			<p class="mt-1 text-sm text-gray-500">
				Vue d’ensemble de votre espace d’administration.
			</p>
		</div>

		{{-- Statistics --}}
		<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
			{{-- Users --}}
			<div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
				<div class="flex items-center justify-between">
					<div>
						<p class="text-sm font-medium text-gray-500">
							Utilisateurs
						</p>

						<p class="mt-2 text-3xl font-semibold tracking-tight text-gray-900">
							{{ $countUsers }}
						</p>
					</div>

					<div class="flex h-11 w-11 items-center justify-center rounded-lg bg-gray-100 text-gray-600">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
							<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
						</svg>
					</div>
				</div>
			</div>
		</div>
	</div>
</x-backoffice-layout>