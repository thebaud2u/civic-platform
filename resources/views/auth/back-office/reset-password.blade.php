<x-guest-layout>
	<h1 id="reset-title" class="mb-4 text-lg font-semibold text-gray-900">
		Définir votre mot de passe
	</h1>

	<form method="POST" action="{{ route('back-office.password.store') }}" aria-labelledby="reset-title">
		@csrf

		<input type="hidden" name="token" value="{{ $request->route('token') }}">

		<!-- Email -->
		<div>
			<x-input-label for="email" value="Email" />
			<x-text-input
				id="email"
				class="block mt-1 w-full"
				type="email"
				name="email"
				placeholder="Email"
				:value="old('email', $request->email)"
				required
				:readonly="filled($request->email)"
				:autofocus="blank($request->email)"
				autocomplete="username"
				inputmode="email"
				autocapitalize="none"
				spellcheck="false"
				:aria-invalid="$errors->has('email') ? 'true' : 'false'"
				:aria-describedby="$errors->has('email') ? 'email-error' : null"
			/>
			<x-input-error id="email-error" role="alert" :messages="$errors->get('email')" class="mt-2" />
		</div>

		<!-- Mot de passe -->
		<div class="mt-4">
			<x-input-label for="password" value="Nouveau mot de passe" />
			<x-text-input
				id="password"
				class="block mt-1 w-full"
				type="password"
				name="password"
				placeholder="Mot de passe"
				required
				:autofocus="filled($request->email)"
				autocomplete="new-password"
				minlength="8"
				:aria-invalid="$errors->has('password') ? 'true' : 'false'"
				:aria-describedby="'password-hint'.($errors->has('password') ? ' password-error' : '')"
			/>
			<p id="password-hint" class="mt-1 text-xs text-gray-600">
				8 caractères minimum.
			</p>
			<x-input-error id="password-error" role="alert" :messages="$errors->get('password')" class="mt-2" />
		</div>

		<!-- Confirmation -->
		<div class="mt-4">
			<x-input-label for="password_confirmation" value="Confirmez le mot de passe" />
			<x-text-input
				id="password_confirmation"
				class="block mt-1 w-full"
				type="password"
				name="password_confirmation"
				placeholder="Mot de passe"
				required
				autocomplete="new-password"
				:aria-invalid="$errors->has('password_confirmation') ? 'true' : 'false'"
				:aria-describedby="$errors->has('password_confirmation') ? 'password-confirmation-error' : null"
			/>
			<x-input-error id="password-confirmation-error" role="alert" :messages="$errors->get('password_confirmation')" class="mt-2" />
		</div>

		<div class="flex items-center justify-end mt-4">
			<x-primary-button type="submit">
				Enregistrer mon mot de passe
			</x-primary-button>
		</div>
	</form>
</x-guest-layout>