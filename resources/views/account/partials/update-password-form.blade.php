@php
	$errs = $errors->updatePassword;
@endphp

<section aria-labelledby="update-password-title">
	<header>
		<h2 id="update-password-title" class="text-lg font-medium text-gray-900">
			Modifier mon mot de passe
		</h2>

		<p id="update-password-intro" class="mt-1 text-sm text-gray-600">
			Assurez-vous d'utiliser un mot de passe long et aléatoire pour rester sécurisé.
		</p>
	</header>

	<form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6" aria-describedby="update-password-intro">
		@csrf
		@method('put')

		<div>
			<x-input-label for="update_password_current_password" value="Mot de passe actuel" />
			<x-text-input
				id="update_password_current_password"
				name="current_password"
				placeholder="Mot de passe actuel"
				type="password"
				class="mt-1 block w-full"
				autocomplete="current-password"
				required
				:aria-invalid="$errs->has('current_password') ? 'true' : 'false'"
				:aria-describedby="$errs->has('current_password') ? 'update_password_current_password_error' : null"
			/>
			<x-input-error id="update_password_current_password_error" role="alert" :messages="$errs->get('current_password')" class="mt-2" />
		</div>

		<div>
			<x-input-label for="update_password_password" value="Nouveau mot de passe" />
			<x-text-input
				id="update_password_password"
				name="password"
				placeholder="Nouveau mot de passe"
				type="password"
				class="mt-1 block w-full"
				autocomplete="new-password"
				required
				minlength="8"
				:aria-invalid="$errs->has('password') ? 'true' : 'false'"
				aria-describedby="update_password_password_hint {{ $errs->has('password') ? 'update_password_password_error' : '' }}"
			/>
			<p id="update_password_password_hint" class="mt-1 text-sm text-gray-600">
				8 caractères minimum.
			</p>
			<x-input-error id="update_password_password_error" role="alert" :messages="$errs->get('password')" class="mt-2" />
		</div>

		<div>
			<x-input-label for="update_password_password_confirmation" value="Confirmez le mot de passe" />
			<x-text-input
				id="update_password_password_confirmation"
				name="password_confirmation"
				placeholder="Confirmez le mot de passe"
				type="password"
				class="mt-1 block w-full"
				autocomplete="new-password"
				required
				:aria-invalid="$errs->has('password_confirmation') ? 'true' : 'false'"
				:aria-describedby="$errs->has('password_confirmation') ? 'update_password_password_confirmation_error' : null"
			/>
			<x-input-error id="update_password_password_confirmation_error" role="alert" :messages="$errs->get('password_confirmation')" class="mt-2" />
		</div>

		<div class="flex items-center justify-end gap-4">
			<x-validate-button>
				Enregistrer
			</x-validate-button>

			{{-- Région live toujours présente dans le DOM, sinon le lecteur d'écran n'annonce rien --}}
			<div role="status" aria-live="polite">
				@if(session('status') === 'password-updated')
					<p class="text-sm text-gray-600">
						Mot de passe enregistré.
					</p>
				@endif
			</div>
		</div>
	</form>
</section>