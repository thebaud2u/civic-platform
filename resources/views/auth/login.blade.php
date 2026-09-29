<x-guest-layout>
	<h1 id="login-title" class="mb-4 text-lg font-semibold text-gray-900">
		Connexion
	</h1>

	<x-auth-session-status class="mb-4" :status="session('status')" role="status" />

	<form method="POST" action="{{ route('login') }}" aria-labelledby="login-title">
		@csrf

		<!-- Email -->
		<div>
			<x-input-label for="email" value="Email" />
			<x-text-input
				id="email"
				class="block mt-1 w-full"
				type="email"
				name="email"
				placeholder="Email"
				:value="old('email')"
				required
				autofocus
				autocomplete="username"
				inputmode="email"
				autocapitalize="none"
				spellcheck="false"
				aria-required="true"
				:aria-invalid="$errors->has('email') ? 'true' : 'false'"
				:aria-describedby="$errors->has('email') ? 'email-error' : null"
			/>
			<x-input-error id="email-error" role="alert" :messages="$errors->get('email')" class="mt-2" />
		</div>

		<!-- Mot de passe -->
		<div class="mt-4">
			<x-input-label for="password" value="Mot de passe" />
			<x-text-input
				id="password"
				class="block mt-1 w-full"
				type="password"
				name="password"
				placeholder="Mot de passe"
				required
				autocomplete="current-password"
				aria-required="true"
				:aria-invalid="$errors->has('password') ? 'true' : 'false'"
				:aria-describedby="$errors->has('password') ? 'password-error' : null"
			/>
			<x-input-error id="password-error" role="alert" :messages="$errors->get('password')" class="mt-2" />
		</div>

		<!-- Se souvenir de moi -->
		<div class="block mt-4">
			<label for="remember_me" class="inline-flex items-center">
				<input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
				<span class="ms-2 text-sm text-gray-600">Se souvenir de moi</span>
			</label>
		</div>

		<div class="flex items-center justify-end mt-4">
			@if (Route::has('password.request'))
				<a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
					Mot de passe oublié ?
				</a>
			@endif

			<x-primary-button type="submit" class="ms-3">
				Se connecter
			</x-primary-button>
		</div>
	</form>
</x-guest-layout>