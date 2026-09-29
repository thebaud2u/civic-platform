<div class="w-full space-y-6">
	<div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
		<div>
			Gérez les comptes admin
		</div>

		<x-primary-button
			wire:click="fresh"
			x-on:click.prevent="$dispatch('open-modal', 'admin-form');"
		>
			<svg
				xmlns="http://www.w3.org/2000/svg"
				fill="none"
				viewBox="0 0 24 24"
				stroke-width="1.5"
				stroke="currentColor"
				class="h-5 w-5"
				aria-hidden="true"
			>
				<path
					stroke-linecap="round"
					stroke-linejoin="round"
					d="M12 4.5v15m7.5-7.5h-15"
				/>
			</svg>

			Créer un admin
		</x-primary-button>
	</div>

	{{-- Filtres --}}
	<div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
		<div class="flex flex-col gap-4 sm:flex-row sm:items-end">
			{{-- Search --}}
			<div class="w-full sm:flex-1">
				<x-input-label for="keyword" value="Recherche" />

				<div class="relative">
					<div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
						<svg
							xmlns="http://www.w3.org/2000/svg"
							fill="none"
							viewBox="0 0 24 24"
							stroke-width="1.5"
							stroke="currentColor"
							class="h-5 w-5"
							aria-hidden="true"
						>
							<path
								stroke-linecap="round"
								stroke-linejoin="round"
								d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.197 5.197a7.5 7.5 0 0 0 10.606 10.606Z"
							/>
						</svg>
					</div>

					<x-text-input
						id="keyword"
						type="search"
						wire:model="keyword"
						class="mt-1 block w-full py-2.5 pl-10"
						placeholder="Nom, email, identifiant..."
					/>
				</div>
			</div>
		</div>
	</div>

	{{-- Table --}}
	<div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
		<div class="overflow-x-auto">
			<table class="w-full min-w-[900px]">
				<caption class="sr-only">Liste des admins</caption>

				<thead class="bg-gray-50">
					<tr>
						<th scope="col"
							class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
							Admin
						</th>

						<th scope="col"
							class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
							Dernière connexion
						</th>

						<th scope="col"
							class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
							Actions
						</th>
					</tr>
				</thead>

				<tbody class="divide-y divide-gray-200">
					@forelse($admins as $adminEntry)
						<tr class="transition-colors hover:bg-gray-50">
							{{-- User --}}
							<td class="px-6 py-4">
								<div class="flex items-center gap-3">
									<div
										class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gray-100 text-sm font-semibold text-gray-600"
										aria-hidden="true"
									>
										{{ strtoupper(substr($adminEntry->first_name, 0, 1) . substr($adminEntry->last_name, 0, 1)) }}
									</div>

									<div class="min-w-0">
										<div class="truncate text-sm font-medium text-gray-900">
											{{ $adminEntry->full_name }}
										</div>

										<div class="truncate text-sm text-gray-500">
											{{ $adminEntry->email }}
										</div>
									</div>
								</div>
							</td>

							{{-- Last connection --}}
							<td class="px-6 py-4 text-sm text-gray-500">
								{{ $adminEntry->last_logon?->format('d/m/Y H:i') ?? 'Jamais' }}
							</td>

							{{-- Actions --}}
							<td class="px-6 py-4">
								<div class="flex justify-end gap-2">
									{{-- Update user --}}
									<x-action-button
										wire:click="getAdmin('{{ $adminEntry->slug }}', 'user-form')"
										title="Modifier les informations de {{ $adminEntry->full_name }}"
										aria-label="Modifier les informations de {{ $adminEntry->full_name }}"
										class="bg-primary-700 text-white focus:ring-primary-700"
									>
										<svg
											xmlns="http://www.w3.org/2000/svg"
											fill="none"
											viewBox="0 0 24 24"
											stroke-width="1.5"
											stroke="currentColor"
											class="h-5 w-5"
											aria-hidden="true"
										>
											<path
												stroke-linecap="round"
												stroke-linejoin="round"
												d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"
											/>
										</svg>
									</x-action-button>

									{{-- Reset password --}}
									<x-action-button
										wire:click="getAdmin('{{ $adminEntry->slug }}', 'reset-password')"
										title="Réinitialiser le mot de passe de {{ $adminEntry->full_name }}"
										aria-label="Réinitialiser le mot de passe de {{ $adminEntry->full_name }}"
										class="bg-primary-700 text-white focus:ring-primary-700"
									>
										<svg
											xmlns="http://www.w3.org/2000/svg"
											fill="none"
											viewBox="0 0 24 24"
											stroke-width="1.5"
											stroke="currentColor"
											class="h-5 w-5"
											aria-hidden="true"
										>
											<path
												stroke-linecap="round"
												stroke-linejoin="round"
												d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"
											/>
										</svg>
									</x-action-button>

									{{-- Enable / disable --}}
									@php
										$toggleLabel = ($adminEntry->trashed() ? 'Activer' : 'Désactiver').' le compte de '.$adminEntry->full_name;
									@endphp
									<x-action-button
										wire:click="getAdmin('{{ $adminEntry->slug }}', 'toggle-account')"
										title="{{ $toggleLabel }}"
										aria-label="{{ $toggleLabel }}"
										class="bg-danger-700 text-white focus:ring-danger-700"
									>
										@if(!$adminEntry->trashed())
											<svg
												xmlns="http://www.w3.org/2000/svg"
												fill="none"
												viewBox="0 0 24 24"
												stroke-width="1.5"
												stroke="currentColor"
												class="h-5 w-5"
												aria-hidden="true"
											>
												<path
													stroke-linecap="round"
													stroke-linejoin="round"
													d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
												/>
											</svg>
										@else
											<svg
												xmlns="http://www.w3.org/2000/svg"
												fill="none"
												viewBox="0 0 24 24"
												stroke-width="1.5"
												stroke="currentColor"
												class="h-5 w-5"
												aria-hidden="true"
											>
												<path
													stroke-linecap="round"
													stroke-linejoin="round"
													d="m9 9 6-6m0 0 6 6m-6-6v12a6 6 0 0 1-12 0v-3"
												/>
											</svg>
										@endif
									</x-action-button>
								</div>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="6" class="px-6 py-12 text-center">
								<div class="flex flex-col items-center justify-center">
									<svg
										xmlns="http://www.w3.org/2000/svg"
										fill="none"
										viewBox="0 0 24 24"
										stroke-width="1.5"
										stroke="currentColor"
										class="mb-3 h-10 w-10 text-gray-300"
										aria-hidden="true"
									>
										<path
											stroke-linecap="round"
											stroke-linejoin="round"
											d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.197 5.197a7.5 7.5 0 0 0 10.606 10.606Z"
										/>
									</svg>

									<p class="text-sm font-medium text-gray-900">
										Aucun résultat
									</p>

									<p class="mt-1 text-sm text-gray-500">
										Aucun admin ne correspond aux critères de recherche.
									</p>
								</div>
							</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>

	{{-- Pagination --}}
	@if($admins->hasPages())
		<div class="rounded-lg border border-gray-200 bg-white px-4 py-3 shadow-sm sm:px-6">
			{{ $admins->links() }}
		</div>
	@endif

	{{-- Modal admin form --}}
	<x-modal
		name="admin-form"
		labelledby="admin-form-title"
		focusable
	>
		<section class="p-6 sm:p-8">
			<header>
				<h2 id="user-form-title" class="text-lg font-semibold text-gray-900">
					{{ $admin->exists ? 'Modifier l\'admin' : 'Créer un admin' }}
				</h2>
			</header>

			<form wire:submit.prevent="adminForm" class="flex flex-col mt-6 space-y-5">
				{{-- Prénom --}}
				<div>
					<x-input-label for="first-name" value="Prénom" :required="true" />
					<x-text-input
						id="first-name"
						type="text"
						wire:model="firstName"
						class="mt-1 block w-full"
						placeholder="Prénom"
						aria-required="true"
						:aria-invalid="$errors->has('firstName') ? 'true' : null"
						:aria-describedby="$errors->has('firstName') ? 'first-name-error' : null"
					/>
					<x-input-error id="first-name-error" :messages="$errors->get('firstName')" class="mt-1" />
				</div>

				{{-- Nom --}}
				<div>
					<x-input-label for="last-name" value="Nom" :required="true" />
					<x-text-input
						id="last-name"
						type="text"
						wire:model="lastName"
						class="mt-1 block w-full"
						placeholder="Nom"
						aria-required="true"
						:aria-invalid="$errors->has('lastName') ? 'true' : null"
						:aria-describedby="$errors->has('lastName') ? 'last-name-error' : null"
					/>
					<x-input-error id="last-name-error" :messages="$errors->get('lastName')" class="mt-1" />
				</div>

				{{-- Email --}}
				<div>
					<x-input-label for="email" value="Email" :required="true" />
					<x-text-input
						id="email"
						type="email"
						wire:model="email"
						class="mt-1 block w-full"
						placeholder="Email"
						aria-required="true"
						:aria-invalid="$errors->has('email') ? 'true' : null"
						:aria-describedby="$errors->has('email') ? 'email-error' : null"
					/>
					<x-input-error id="email-error" :messages="$errors->get('email')" class="mt-1" />
				</div>

				{{-- Buttons --}}
				<div class="flex flex-col-reverse gap-3 pt-2 sm:flex-row sm:justify-end">
					<x-cancel-button />

					<x-validate-button @admin-form-complete.window="$dispatch('close')">
						{{ $admin->exists ? 'Modifier l\'admin' : 'Créer l\'admin' }}
					</x-validate-button>
				</div>
			</form>
		</section>
	</x-modal>

	{{-- Modal admin disabling / enabling --}}
	<x-modal
		name="toggle-account"
		labelledby="toggle-account-title"
		focusable
	>
		<section class="p-6 sm:p-8">
			<header>
				<h2 id="toggle-account-title" class="text-lg font-semibold text-gray-900">
					{{ $switchState }} ?
				</h2>

				<p class="mt-2 text-sm text-gray-500">
					Cette action modifiera l'état du compte admin.
				</p>
			</header>

			<form wire:submit.prevent="toggleAdmin">
				<div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
					<x-cancel-button />

					<x-validate-button @account-toggled.window="$dispatch('close');">
						{{ $switchState }}
					</x-validate-button>
				</div>
			</form>
		</section>
	</x-modal>

	{{-- Modal reset password --}}
	<x-modal
		name="reset-password"
		labelledby="reset-password-title"
		focusable
	>
		<section class="p-6 sm:p-8">
			<header>
				<h2 id="reset-password-title" class="text-lg font-semibold text-gray-900">
					Réinitialiser le mot de passe ?
				</h2>

				<p class="mt-2 text-sm text-gray-500">
					L'admin recevra un email lui permettant de définir un nouveau mot de passe.
				</p>
			</header>

			<form wire:submit.prevent="resetPassword">
				<div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
					<x-cancel-button />

					<x-validate-button @password-changed.window="$dispatch('close');">
						Réinitialiser
					</x-validate-button>
				</div>
			</form>
		</section>
	</x-modal>
</div>