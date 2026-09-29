<x-guest-layout>
	<div class="flex flex-col gap-4">
		<header>
			<h1
				id="reset-password-title"
				class="text-lg font-semibold text-gray-900"
			>
				Définir un nouveau mot de passe
			</h1>

			<p
				id="reset-password-help"
				class="text-sm text-gray-600"
			>
				Choisissez un nouveau mot de passe pour votre compte.
			</p>
		</header>

		<form
			method="POST"
			action="{{ route('password.store') }}"
			aria-labelledby="reset-password-title"
			aria-describedby="reset-password-help"
		>
			@csrf

			<!-- Password Reset Token -->
			<input
				type="hidden"
				name="token"
				value="{{ $request->route('token') }}"
			>

			<!-- Email Address -->
			<div>
				<x-input-label
					for="email"
					value="Adresse e-mail"
				/>

				<x-text-input
					id="email"
					class="mt-1 block w-full"
					type="email"
					name="email"
					:value="old('email', $request->email)"
					required
					autofocus
					autocomplete="email"
					inputmode="email"
					autocapitalize="none"
					spellcheck="false"
					:aria-invalid="$errors->has('email') ? 'true' : 'false'"
					:aria-errormessage="$errors->has('email') ? 'email-error' : null"
					:aria-describedby="$errors->has('email') ? 'email-error' : null"
				/>

				<x-input-error
					id="email-error"
					role="alert"
					:messages="$errors->get('email')"
					class="mt-2"
				/>
			</div>

			<!-- Password -->
			<div class="mt-4">
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
					autocomplete="new-password"
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

			<!-- Confirm Password -->
			<div class="mt-4">
				<x-input-label
					for="password_confirmation"
					value="Confirmer le mot de passe"
				/>

				<x-text-input
					id="password_confirmation"
					class="mt-1 block w-full"
					type="password"
					name="password_confirmation"
					required
					autocomplete="new-password"
					:aria-invalid="$errors->has('password_confirmation') ? 'true' : 'false'"
					:aria-errormessage="$errors->has('password_confirmation') ? 'password-confirmation-error' : null"
					:aria-describedby="$errors->has('password_confirmation') ? 'password-confirmation-error' : null"
				/>

				<x-input-error
					id="password-confirmation-error"
					role="alert"
					:messages="$errors->get('password_confirmation')"
					class="mt-2"
				/>
			</div>

			<div class="mt-4 flex items-center justify-end">
				<x-primary-button type="submit">
					Définir mon mot de passe
				</x-primary-button>
			</div>
		</form>
	</div>
</x-guest-layout>