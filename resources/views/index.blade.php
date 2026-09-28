<x-guest-layout>
	<div class="flex flex-col gap-y-4 py-4">
		<div>
			Bienvenue sur l'intranet de la mairie de {{ config('app.town_name') }}
		</div>

		<div class="flex flex-row items-center justify-center gap-x-2">
			<a href="{{ route('login') }}">
				<x-primary-button>
					Connexion
				</x-primary-button>
			</a>
		</div>
	</div>
</x-guest-layout>
