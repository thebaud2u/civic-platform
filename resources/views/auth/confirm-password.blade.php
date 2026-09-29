<x-guest-layout>
	<div class="flex flex-col gap-4">
		<header>
			<h1
				id="confirm-password-title"
				class="text-lg font-semibold text-gray-900"
			>
				Confirmer votre mot de passe
			</h1>

			<p
				id="confirm-password-help"
				class="text-sm text-gray-600"
			>
				Cette zone est sécurisée. Veuillez confirmer votre mot de passe
				avant de continuer.
			</p>
		</header>

		<form
			method="POST"
			action="{{ route('password.confirm') }}"
			aria-labelledby="confirm-password-title"
			aria-describedby="confirm-password-help"
		>
			@csrf

			<div>
				<x-input-label
					for="password"
					value="Mot de passe"
				/>

				<x-text-input
					id="password"
					class="mt-1 block w-full"
					type="password"
					name="password"
					required
					autofocus
					autocomplete="current-password"
					:aria-invalid="$errors->has('password') ? 'true' : 'false'"
					:aria-errormessage="$errors->has('password') ? 'password-error' : null"
					:aria-describedby="$errors->has('password') ? 'password-error' : null"
				/>

				<x-input-error
					id="password-error"
					role="alert"
					:messages="$errors->get('password')"
					class="mt-2"
				/>
			</div>

			<div class="mt-4 flex justify-end">
				<x-primary-button type="submit">
					Confirmer le mot de passe
				</x-primary-button>
			</div>
		</form>
	</div>
</x-guest-layout>
