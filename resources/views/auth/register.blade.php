<x-guest-layout>
	<form method="POST" action="{{ route('register') }}">
		@csrf

		<!-- Nom -->
		<div>
			<x-input-label for="lastName" :value="'Nom'" />
			<x-text-input id="lastName" class="block mt-1 w-full" type="text" name="lastName" :value="old('lastName')" required autofocus autocomplete="lastName" />
			<x-input-error :messages="$errors->get('lastName')" class="mt-2" />
		</div>

		<!-- Prénom -->
		 <div class="mt-4">
			<x-input-label for="firstName" :value="'Prénom'" />
			<x-text-input id="firstName" class="block mt-1 w-full" type="text" name="firstName" :value="old('firstName')" required autofocus autocomplete="firstName" />
			<x-input-error :messages="$errors->get('firstName')" class="mt-2" />
		</div>

		<!-- Email Address -->
		<div class="mt-4">
			<x-input-label for="email" :value="'Email'" />
			<x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" />
			<x-input-error :messages="$errors->get('email')" class="mt-2" />
		</div>

		<!-- Password -->
		<div class="mt-4">
			<x-input-label for="password" :value="'Mot de passe'" />
			<x-text-input id="password" class="block mt-1 w-full" type="password" name="password"  required autocomplete="new-password" />
			<x-input-error :messages="$errors->get('password')" class="mt-2" />
		</div>

		<!-- Confirm Password -->
		<div class="mt-4">
			<x-input-label for="password_confirmation" :value="'Confirmez le mot de passe'" />
			<x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
			<x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
		</div>

		<div class="flex items-center justify-end mt-4">
			<a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
				Vous avez déjà un compte ?
			</a>

			<x-primary-button class="ms-4">
				Créer mon compte
			</x-primary-button>
		</div>
	</form>
</x-guest-layout>
