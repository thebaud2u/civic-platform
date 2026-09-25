<div class="w-full space-y-6">
	<div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
		<div>
			Gérez les comptes des agents et chefs de service
		</div>

		<button
			type="button"
			x-data
			x-on:click="$dispatch('open-modal', 'user-form')"
			class="inline-flex items-center justify-end gap-2 rounded-md bg-primary-700 px-4 py-2.5
				text-sm font-medium text-white shadow-sm transition
				hover:opacity-90
				focus:outline-none focus:ring-2 focus:ring-primary-700 focus:ring-offset-2"
		>
			<svg
				xmlns="http://www.w3.org/2000/svg"
				fill="none"
				viewBox="0 0 24 24"
				stroke-width="1.5"
				stroke="currentColor"
				class="h-5 w-5"
			>
				<path
					stroke-linecap="round"
					stroke-linejoin="round"
					d="M12 4.5v15m7.5-7.5h-15"
				/>
			</svg>

			Créer un utilisateur
		</button>
	</div>

	{{-- Filtres --}}
	<div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
		<div class="flex flex-col gap-4 sm:flex-row sm:items-end">
			{{-- Role --}}
			<div class="w-full sm:w-auto sm:min-w-52">
				<label for="role-filters" class="mb-1.5 block text-sm font-medium text-gray-700">
					Rôle
				</label>

				<select
					id="role-filters"
					wire:model.live="role"
					class="block w-full rounded-md border-gray-300 text-sm shadow-sm
						   focus:border-primary-700 focus:ring-primary-700"
				>
					<option value="">Tous les rôles</option>

					@foreach($roles as $roleFiltersEntry)
						<option value="{{ $roleFiltersEntry->id }}">
							{{ ucfirst($roleFiltersEntry->name) }}
						</option>
					@endforeach
				</select>
			</div>

			{{-- Service --}}
			<div class="w-full sm:w-auto sm:min-w-52">
				<label for="service-filters" class="mb-1.5 block text-sm font-medium text-gray-700">
					Service
				</label>

				<select
					id="service-filters"
					wire:model.live="service"
					class="block w-full rounded-md border-gray-300 text-sm shadow-sm
						   focus:border-primary-700 focus:ring-primary-700"
				>
					<option value="">Tous les services</option>

					@foreach($services as $serviceFiltersEntry)
						<option value="{{ $serviceFiltersEntry->slug }}">
							{{ ucfirst($serviceFiltersEntry->name) }}
						</option>
					@endforeach
				</select>
			</div>

			{{-- Manager --}}
			<div class="w-full sm:w-auto sm:min-w-52">
				<label for="manager-filters" class="mb-1.5 block text-sm font-medium text-gray-700">
					Manager
				</label>

				<select
					id="manager-filters"
					wire:model.live="manager"
					class="block w-full rounded-md border-gray-300 text-sm shadow-sm
						   focus:border-primary-700 focus:ring-primary-700"
				>
					<option value="">Tous les chefs de service</option>

					@foreach($roles as $managerFiltersEntry)
						<option value="{{ $managerFiltersEntry->slug }}">
							{{ ucfirst($managerFiltersEntry->name) }}
						</option>
					@endforeach
				</select>
			</div>

			{{-- Recherche --}}
			<div class="w-full sm:flex-1">
				<label for="keyword" class="mb-1.5 block text-sm font-medium text-gray-700">
					Recherche
				</label>

				<div class="relative">
					<div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
						<svg
							xmlns="http://www.w3.org/2000/svg"
							fill="none"
							viewBox="0 0 24 24"
							stroke-width="1.5"
							stroke="currentColor"
							class="h-5 w-5"
						>
							<path
								stroke-linecap="round"
								stroke-linejoin="round"
								d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.197 5.197a7.5 7.5 0 0 0 10.606 10.606Z"
							/>
						</svg>
					</div>

					<input
						type="text"
						wire:model.live="keyword"
						name="keyword"
						id="keyword"
						placeholder="Nom, email, identifiant..."
						class="block w-full rounded-md border-gray-300 py-2.5 pl-10 text-sm shadow-sm
							   focus:border-primary-700 focus:ring-primary-700"
					/>
				</div>
			</div>
		</div>
	</div>

	{{-- Tableau --}}
	<div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
		<div class="overflow-x-auto">
			<table class="w-full min-w-[900px]">
				<thead class="bg-gray-50">
					<tr>
						<th scope="col"
							class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
							Utilisateur
						</th>

						<th scope="col"
							class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
							Rôle
						</th>

						<th scope="col"
							class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
							Service
						</th>

						<th scope="col"
							class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
							Manager
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
					@forelse($users as $userEntry)
						<tr class="transition-colors hover:bg-gray-50">
							{{-- Utilisateur --}}
							<td class="px-6 py-4">
								<div class="flex items-center gap-3">
									<div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gray-100 text-sm font-semibold text-gray-600">
										{{ strtoupper(substr($userEntry->first_name, 0, 1) . substr($userEntry->last_name, 0, 1)) }}
									</div>

									<div class="min-w-0">
										<div class="truncate text-sm font-medium text-gray-900">
											{{ $userEntry->fullName }}
										</div>

										<div class="truncate text-sm text-gray-500">
											{{ $userEntry->email }}
										</div>
									</div>
								</div>
							</td>

							{{-- Rôle --}}
							<td class="px-6 py-4">
								@if($userEntry->roles->isNotEmpty())
									@if($userEntry->hasRole('agent'))
										<span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700">
											Agent
										</span>
									@elseif($userEntry->hasRole('chef de service'))
										<span class="inline-flex items-center rounded-full bg-purple-50 px-2.5 py-1 text-xs font-medium text-purple-700">
											Chef de service
										</span>
									@endif
								@else
									<span class="text-sm text-gray-400">
										Aucun rôle
									</span>
								@endif
							</td>

							{{-- Service --}}
							<td class="px-6 py-4 text-sm text-gray-700">
								{{ $userEntry->service?->name ?? '—' }}
							</td>

							{{-- Manager --}}
							<td class="px-6 py-4 text-sm text-gray-700">
								{{ $userEntry->manager?->fullName() ?? '—' }}
							</td>

							{{-- Dernière connexion --}}
							<td class="px-6 py-4 text-sm text-gray-500">
								{{ $userEntry->last_logon?->format('d/m/Y H:i') ?? 'Jamais' }}
							</td>

							{{-- Actions --}}
							<td class="px-6 py-4">
								<div class="flex justify-end gap-2">
									<button
										type="button"
										wire:click="getUser('{{ $userEntry->slug }}', 'user-form')"
										title="Modifier le service"
										class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-gray-300
											   bg-white text-gray-600 transition
											   hover:bg-gray-50 hover:text-gray-900
											   focus:outline-none focus:ring-2 focus:ring-primary-700 focus:ring-offset-1"
									>
										<svg
											xmlns="http://www.w3.org/2000/svg"
											fill="none"
											viewBox="0 0 24 24"
											stroke-width="1.5"
											stroke="currentColor"
											class="h-5 w-5"
										>
											<path
												stroke-linecap="round"
												stroke-linejoin="round"
												d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"
											/>
										</svg>
									</button>

									{{-- Reset password --}}
									<button
										type="button"
										wire:click="getUser({{ $userEntry->slug }}, 'reset-password')"
										title="Réinitialiser le mot de passe"
										class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-gray-300
											   bg-white text-gray-600 transition
											   hover:bg-gray-50 hover:text-gray-900
											   focus:outline-none focus:ring-2 focus:ring-primary-700 focus:ring-offset-1"
									>
										<svg
											xmlns="http://www.w3.org/2000/svg"
											fill="none"
											viewBox="0 0 24 24"
											stroke-width="1.5"
											stroke="currentColor"
											class="h-5 w-5"
										>
											<path
												stroke-linecap="round"
												stroke-linejoin="round"
												d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"
											/>
										</svg>
									</button>

									{{-- Activer / désactiver --}}
									<button
										type="button"
										wire:click="getUser({{ $userEntry->slug }}, 'toggle-account')"
										title="{{ !$userEntry->trashed() ? 'Désactiver le compte' : 'Activer le compte' }}"
										class="inline-flex h-9 w-9 items-center justify-center rounded-md border transition
											   focus:outline-none focus:ring-2 focus:ring-offset-1
											   {{ $userEntry->trashed()
													? 'border-green-200 bg-green-50 text-green-600 hover:bg-green-100 focus:ring-green-500'
													: 'border-red-200 bg-red-50 text-red-600 hover:bg-red-100 focus:ring-red-500'
											   }}"
									>
										@if(!$userEntry->trashed())
											<svg
												xmlns="http://www.w3.org/2000/svg"
												fill="none"
												viewBox="0 0 24 24"
												stroke-width="1.5"
												stroke="currentColor"
												class="h-5 w-5"
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
												viewBox="0 0 24 24"
												stroke="currentColor"
												class="h-5 w-5"
											>
												<path
													stroke-linecap="round"
													stroke-linejoin="round"
													d="m9 9 6-6m0 0 6 6m-6-6v12a6 6 0 0 1-12 0v-3"
												/>
											</svg>
										@endif
									</button>
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
										Aucun utilisateur ne correspond aux critères de recherche.
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
	@if($users->hasPages())
		<div class="rounded-lg border border-gray-200 bg-white px-4 py-3 shadow-sm sm:px-6">
			{{ $users->links() }}
		</div>
	@endif

	<x-modal
		name="user-form"
		:class="'w-full max-w-2xl'"
		focusable
	>
		<section class="p-6 sm:p-8">
			<header>
				<h2 class="text-lg font-semibold text-gray-900">
					{{ $user->exists ? 'Modifier l\'utilisateur' : 'Créer un utilisateur' }}
				</h2>
			</header>

			<form wire:submit.prevent="userForm" class="flex flex-col mt-6 space-y-5">
				{{-- Civilité --}}
				<div>
					<span class="block text-sm font-medium text-gray-700">
						Civilité
					</span>

					<div class="mt-2 flex items-center gap-6">
						<label class="inline-flex items-center gap-2">
							<input
								type="radio"
								name="gender"
								value="mr"
								wire:model="gender"
								class="border-gray-300 text-mnw-deepblue
									focus:ring-mnw-deepblue"
							>
							<span class="text-sm text-gray-700">Mr</span>
						</label>

						<label class="inline-flex items-center gap-2">
							<input
								type="radio"
								name="gender"
								value="mme"
								wire:model="gender"
								class="border-gray-300 text-mnw-deepblue
									focus:ring-mnw-deepblue"
							>
							<span class="text-sm text-gray-700">Mme</span>
						</label>

						<label class="inline-flex items-center gap-2">
							<input
								type="radio"
								name="gender"
								value="autre"
								wire:model="gender"
								class="border-gray-300 text-mnw-deepblue
									focus:ring-mnw-deepblue"
							>
							<span class="text-sm text-gray-700">Autre</span>
						</label>
					</div>

					@error('gender')
						<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
					@enderror
				</div>

				{{-- Name --}}
				<div>
					<label for="first-name" class="block text-sm font-medium text-gray-700">
						Prénom
					</label>

					<input
						type="text"
						id="first-name"
						wire:model="firstName"
						class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
							focus:border-mnw-deepblue focus:ring-mnw-deepblue"
					>

					@error('firstName')
						<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
					@enderror
				</div>

				<div>
					<label for="last-name" class="block text-sm font-medium text-gray-700">
						Nom
					</label>

					<input
						type="text"
						id="last-name"
						wire:model="lastName"
						class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
							focus:border-mnw-deepblue focus:ring-mnw-deepblue"
					>

					@error('lastName')
						<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
					@enderror
				</div>

				{{-- Email --}}
				<div>
					<label for="email" class="block text-sm font-medium text-gray-700">
						Email
					</label>

					<input
						type="email"
						id="email"
						wire:model="email"
						class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
							focus:border-mnw-deepblue focus:ring-mnw-deepblue"
					>

					@error('email')
						<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
					@enderror
				</div>

				{{-- Date de naissance --}}
				<div>
					<label for="birthday" class="block text-sm font-medium text-gray-700">
						Date de naissance
					</label>

					<input
						type="date"
						id="birthday"
						wire:model="birthday"
						class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
							focus:border-mnw-deepblue focus:ring-mnw-deepblue"
					>

					@error('birthday')
						<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
					@enderror
				</div>

				{{-- Téléphone / Mobile --}}
				<div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
					<div>
						<label for="phone" class="block text-sm font-medium text-gray-700">
							Téléphone
						</label>

						<input
							type="tel"
							id="phone"
							wire:model="phone"
							class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
								focus:border-mnw-deepblue focus:ring-mnw-deepblue"
						>

						@error('phone')
							<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
						@enderror
					</div>

					<div>
						<label for="mobile" class="block text-sm font-medium text-gray-700">
							Mobile
						</label>

						<input
							type="tel"
							id="mobile"
							wire:model="mobile"
							class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
								focus:border-mnw-deepblue focus:ring-mnw-deepblue"
						>

						@error('mobile')
							<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
						@enderror
					</div>
				</div>

				{{-- Rôle --}}
				<div>
					<span class="block text-sm font-medium text-gray-700">
						Rôle
					</span>

					<div class="mt-2 flex items-center gap-6">
						@foreach($roles as $roleFormEntry)
							<label class="inline-flex items-center gap-2">
								<input
									type="radio"
									name="role"
									value="{{ $roleFormEntry->name }}"
									wire:model="roleSelected"
									class="border-gray-300 text-mnw-deepblue
										focus:ring-mnw-deepblue"
								>
								<span class="text-sm text-gray-700">{{ ucfirst($roleFormEntry->name) }}</span>
							</label>
						@endforeach
					</div>

					@error('roleSelected')
						<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
					@enderror
				</div>

				{{-- Service --}}
				<div>
					<label for="service" class="block text-sm font-medium text-gray-700">
						Service
					</label>

					<select
						id="service"
						wire:model="serviceSelected"
						class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
							focus:border-mnw-deepblue focus:ring-mnw-deepblue"
					>
						<option value="">Aucun service</option>

						@foreach($services as $serviceFormEntry)
							<option value="{{ $serviceFormEntry->slug }}">
								{{ $serviceFormEntry->name }}
							</option>
						@endforeach
					</select>

					@error('service_id')
						<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
					@enderror
				</div>

				{{-- Manager --}}
				<div>
					<label for="manager" class="block text-sm font-medium text-gray-700">
						Chef de service
					</label>

					<select
						id="manager"
						wire:model="managerSelected"
						class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
							focus:border-mnw-deepblue focus:ring-mnw-deepblue"
					>
						<option value="">Aucun chef de service</option>

						@foreach($managers as $managerFormEntry)
							<option value="{{ $managerFormEntry->slug }}">
								{{ $managerFormEntry->name }}
							</option>
						@endforeach
					</select>

					@error('managerSelected')
						<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
					@enderror
				</div>

				{{-- Boutons --}}
				<div class="flex flex-col-reverse gap-3 pt-2 sm:flex-row sm:justify-end">
					<x-secondary-button
						type="button"
						x-on:click="$dispatch('close')"
					>
						Annuler
					</x-secondary-button>

					<x-primary-button type="submit" @user-form-complete.window="$dispatch('close')">
						{{ $user->exists ? 'Modifier l\'utilisateur' : 'Créer l\'utilisateur' }}
					</x-primary-button>
				</div>
			</form>
		</section>
	</x-modal>

	{{-- Modal désactivation / activation --}}
	<x-modal
		name="toggle-account"
		:class="'w-full max-w-lg'"
		focusable
	>
		<section class="p-6 sm:p-8">
			<header>
				<h2 class="text-lg font-semibold text-gray-900">
					{{ $switchState }} ?
				</h2>

				<p class="mt-2 text-sm text-gray-500">
					Cette action modifiera l'état du compte utilisateur.
				</p>
			</header>

			<div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
				<x-secondary-button x-on:click="$dispatch('close');">
					Annuler
				</x-secondary-button>

				<x-primary-button
					wire:click="toggleUser"
					@account-toggled.window="$dispatch('close');"
				>
					{{ $switchState }}
				</x-primary-button>
			</div>
		</section>
	</x-modal>

	{{-- Modal reset password --}}
	<x-modal
		name="reset-password"
		:class="'w-full max-w-lg'"
		focusable
	>
		<section class="p-6 sm:p-8">
			<header>
				<h2 class="text-lg font-semibold text-gray-900">
					Réinitialiser le mot de passe ?
				</h2>

				<p class="mt-2 text-sm text-gray-500">
					L'utilisateur recevra un email lui permettant de définir un nouveau mot de passe.
				</p>
			</header>

			<div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
				<x-secondary-button x-on:click="$dispatch('close');">
					Annuler
				</x-secondary-button>

				<x-primary-button
					wire:click="resetPassword"
					@password-changed.window="$dispatch('close');"
				>
					Réinitialiser
				</x-primary-button>
			</div>
		</section>
	</x-modal>
</div>
