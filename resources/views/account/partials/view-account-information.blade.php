<section>
	<header>
		<h2 class="text-lg font-medium text-gray-900">
			Informations de votre compte
		</h2>

		<p class="mt-1 text-sm text-gray-600">
			Voici les informations de votre compte.
		</p>
	</header>

	<div class="mt-6 space-y-2">
		<p class="mt-1 text-sm text-gray-600">
			{{ ucfirst($user->gender).' '.$user->full_name }} ({{ $user->email }})
		</p>

		<p class="mt-1 text-sm text-gray-600">
			{{ ucfirst($user->roles()->first()?->name ?? '—') }} {{ $user->service ? 'du service '.strtolower($user->service->name) : '' }} à la mairie de {{ config('app.town_name') }}
		</p>

		@if($user->manager)
			<p class="mt-1 text-sm text-gray-600">
				{{ $user->gender == 'Mr' ? 'Managé' : 'Managée' }} par {{ $user->manager->full_name }}
			</p>
		@endif

		<p class="mt-1 text-sm text-gray-600">
			@if($user->contractType->name == 'Titulaire' || $user->contractType->name == 'Contractuel')
				{{ $user->contractType->name }}
			@else
				{{ 'En '.$user->contractType->name }}
			@endif

			{{ ' en '.strtolower($user->workSchedule->name) }}
		</p>
	</div>
</section>
