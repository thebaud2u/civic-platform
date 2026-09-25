<x-guest-layout>
	<div class="flex flex-col gap-y-4 py-4">
		<div>
			Bienvenue sur l'intranet de la mairie de {{ config('app.town_name') }}
		</div>

		<div class="flex flex-row items-center justify-center gap-x-2">
			<a
				href="{{ route('login') }}"
				class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-gray-700"
			>
				Connexion
			</a>
		</div>
	</div>
</x-guest-layout>
