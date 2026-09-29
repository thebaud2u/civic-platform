<x-guest-layout>
	<div class="flex flex-col gap-x-4">
		<h1 id="forgot-title" class="mb-2 text-lg font-semibold text-gray-900">
			Mot de passe oublié
		</h1>

		<p id="forgot-help" class="mb-4 text-sm text-gray-600">
			Vous avez oublié votre mot de passe ? Pas de problème. Indiquez-nous votre adresse e-mail et nous vous enverrons un lien de réinitialisation qui vous permettra d'en choisir un nouveau.
		</p>

		<x-auth-session-status class="mb-4" :status="session('status')" role="status" />

		<form method="POST" action="{{ route('password.email') }}" aria-labelledby="forgot-title">
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
					:aria-invalid="$errors->has('email') ? 'true' : 'false'"
					:aria-describedby="'forgot-help'.($errors->has('email') ? ' email-error' : '')"
				/>
				<x-input-error id="email-error" role="alert" :messages="$errors->get('email')" class="mt-2" />
			</div>

			<div class="flex items-center justify-end mt-4">
				<x-primary-button type="submit">
					Envoyer le lien de réinitialisation
				</x-primary-button>
			</div>
		</form>
	</div>
</x-guest-layout>