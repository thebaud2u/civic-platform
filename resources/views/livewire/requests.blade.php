<div class="p-6 text-gray-900">
	<header class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-8">
		<div>
			<h2 class="text-xl font-semibold text-gray-800">
				@if($user->slug != Auth::user()->slug)
					Les temps de {{ $user->full_name }}
				@else
					Mes temps
				@endif
			</h2>

			<p class="mt-1 text-sm text-gray-600">
				Suivi {{ $user->slug != Auth::user()->slug ? 'des' : 'de votre' }} temps de travail pour la semaine en cours.
			</p>
		</div>

		@role('chef de service')
			<div class="flex flex-row gap-x-2 items-end justify-center">
				<div>
					<x-input-label for="users-filter" value="Voir les temps d'un agent" />

					<x-select-input
						id="users-filter"
						wire:model.live="filterUserSelected"
						class="mt-1 block w-full"
						:aria-invalid="$errors->has('filterUserSelected') ? 'true' : null"
						:aria-describedby="$errors->has('filterUserSelected') ? 'users-filter' : null"
					>
						<option value="">Aucun agent</option>
						@foreach($users as $userFiltersEntry)
							<option value="{{ $userFiltersEntry->slug }}">
								{{ $userFiltersEntry->full_name }}
							</option>
						@endforeach
					</x-select-input>
				</div>
			</div>
		@endrole
	</header>

	{{-- Navigation buttons --}}
	<div class="flex flex-row items-center justify-between mb-8">
		<x-primary-button
			type="button"
			wire:click="previousMonth"
		>
			<svg
				xmlns="http://www.w3.org/2000/svg"
				fill="none"
				viewBox="0 0 24 24"
				stroke-width="1.5"
				stroke="currentColor"
				class="h-5 w-5"
			>
			<path
				stroke-linecap="round"
				stroke-linejoin="round"
				d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18"
			/>
			</svg>

			Mois précédent
		</x-primary-button>

		<x-primary-button
			type="button"
			wire:click="nextMonth"
		>
			Mois suivant

			<svg
				xmlns="http://www.w3.org/2000/svg"
				fill="none"
				viewBox="0 0 24 24"
				stroke-width="1.5"
				stroke="currentColor"
				class="h-5 w-5"
			>
			<path
				stroke-linecap="round"
				stroke-linejoin="round"
				d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3"
			/>
			</svg>
		</x-primary-button>
	</div>

	{{-- Summary of the week --}}
	<section aria-labelledby="week-summary-title" class="mb-8">
		<div class="mb-4">
			<h3
				id="week-details-title"
				class="text-lg font-semibold text-gray-800"
			>
				Compteurs
			</h3>
		</div>

		<div class="grid gap-4 sm:grid-cols-3">
			{{-- Time achieved --}}
			<div class="rounded-lg border border-gray-200 p-5">
				<p class="text-sm font-medium text-gray-600">
					Congés
				</p>

				<p class="mt-2 text-2xl font-semibold text-gray-900">
					{{ $user->dayOffBalance->formatted }}
				</p>
			</div>

			{{-- Expected time --}}
			<div class="rounded-lg border border-gray-200 p-5">
				<p class="text-sm font-medium text-gray-600">
					Récupération
				</p>

				<p class="mt-2 text-2xl font-semibold text-gray-900">
					{{ $user->recoveryBalance->formatted }}
				</p>
			</div>
		</div>
	</section>

	{{-- Month Detail --}}
	<section aria-labelledby="week-details-title">
		<div class="mb-4">
			<h3
				id="week-details-title"
				class="text-lg font-semibold text-gray-800"
			>
				
			</h3>
		</div>

		
	</section>
</div>