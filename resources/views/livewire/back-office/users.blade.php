<div class="w-full space-y-6">
	<div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
		<div>
			Gérez les comptes des agents et chefs de service
		</div>

		<x-primary-button
			wire:click="fresh"
			x-on:click.prevent="$dispatch('open-modal', 'user-form');"
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

			Créer un utilisateur
		</x-primary-button>
	</div>

	{{-- Filtres --}}
	<div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
		<div class="mb-4">
			<h2 class="text-sm font-semibold text-gray-900">
				Filtrer les utilisateurs
			</h2>

			<p class="mt-1 text-sm text-gray-500">
				Utilisez les critères ci-dessous pour affiner la liste.
			</p>
		</div>

		<div class="space-y-4">
			{{-- Search --}}
			<div class="w-full">
				<x-input-label for="keyword" value="Recherche" />

				<div class="relative mt-1">
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
						wire:model.live="keyword"
						class="block w-full py-2.5 pl-10"
						placeholder="Nom, email, identifiant..."
					/>
				</div>
			</div>

			{{-- Select filters --}}
			<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 mt-4">
				{{-- Role --}}
				<div>
					<x-input-label for="role-filters" value="Rôle" />

					<x-select-input
						id="role-filters"
						wire:model.live="role"
						class="mt-1 block w-full"
					>
						<option value="">Tous les rôles</option>

						@foreach($roles as $roleFiltersEntry)
							<option value="{{ $roleFiltersEntry->id }}">
								{{ ucfirst($roleFiltersEntry->name) }}
							</option>
						@endforeach
					</x-select-input>
				</div>

				{{-- Service --}}
				<div>
					<x-input-label for="service-filters" value="Service" />

					<x-select-input
						id="service-filters"
						wire:model.live="service"
						class="mt-1 block w-full"
					>
						<option value="">Tous les services</option>

						@foreach($services as $serviceFiltersEntry)
							<option value="{{ $serviceFiltersEntry->slug }}">
								{{ $serviceFiltersEntry->name }}
							</option>
						@endforeach
					</x-select-input>
				</div>

				{{-- Manager --}}
				<div>
					<x-input-label for="manager-filters" value="Chef de service" />

					<x-select-input
						id="manager-filters"
						wire:model.live="manager"
						class="mt-1 block w-full"
					>
						<option value="">Tous les chefs de service</option>

						@foreach($managers as $managerFiltersEntry)
							<option value="{{ $managerFiltersEntry->slug }}">
								{{ $managerFiltersEntry->full_name }}
							</option>
						@endforeach
					</x-select-input>
				</div>

				{{-- Contract type --}}
				<div>
					<x-input-label for="contract-type-filters" value="Type de contrat" />

					<x-select-input
						id="contract-type-filters"
						wire:model.live="contractType"
						class="mt-1 block w-full"
					>
						<option value="">Tous les types de contrat</option>

						@foreach($contractTypes as $contractTypeFiltersEntry)
							<option value="{{ $contractTypeFiltersEntry->id }}">
								{{ $contractTypeFiltersEntry->name }}
							</option>
						@endforeach
					</x-select-input>
				</div>

				{{-- Work schedule --}}
				<div>
					<x-input-label for="work-schedule-filters" value="Régime de travail" />

					<x-select-input
						id="work-schedule-filters"
						wire:model.live="workSchedule"
						class="mt-1 block w-full"
					>
						<option value="">Tous les régimes de travail</option>

						@foreach($workSchedules as $workScheduleFiltersEntry)
							<option value="{{ $workScheduleFiltersEntry->id }}">
								{{ $workScheduleFiltersEntry->name }}
							</option>
						@endforeach
					</x-select-input>
				</div>
			</div>
		</div>
	</div>

	{{-- Table --}}
	<div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
		<div class="overflow-x-auto">
			<table class="w-full min-w-[900px]">
				<caption class="sr-only">Liste des utilisateurs</caption>

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
							{{-- User --}}
							<td class="px-6 py-4">
								<div class="flex items-center gap-3">
									<div
										class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gray-100 text-sm font-semibold text-gray-600"
										aria-hidden="true"
									>
										{{ strtoupper(substr($userEntry->first_name, 0, 1) . substr($userEntry->last_name, 0, 1)) }}
									</div>

									<div class="min-w-0">
										<div class="truncate text-sm font-medium text-gray-900">
											{{ $userEntry->full_name }}
										</div>

										<div class="truncate text-sm text-gray-500">
											{{ $userEntry->email }}
										</div>
									</div>
								</div>
							</td>

							{{-- Role --}}
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
								{{ $userEntry->manager?->full_name ?? '—' }}
							</td>

							{{-- Last connection --}}
							<td class="px-6 py-4 text-sm text-gray-500">
								{{ $userEntry->last_logon?->format('d/m/Y H:i') ?? 'Jamais' }}
							</td>

							{{-- Actions --}}
							<td class="px-6 py-4">
								<div class="flex justify-end gap-2">
									{{-- Update user --}}
									<x-action-button
										wire:click="getUser('{{ $userEntry->slug }}', 'user-form')"
										title="Modifier les informations de {{ $userEntry->full_name }}"
										aria-label="Modifier les informations de {{ $userEntry->full_name }}"
										class="bg-primary-700 text-white focus:ring-primary-700"
									>
										<svg
											xmlns="http://www.w3.org/2000/svg"
											fill="none"
											viewBox="0 0 24 24"
											stroke-width="1.5"
											stroke="currentColor"
											class="size-5"
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
										wire:click="getUser('{{ $userEntry->slug }}', 'reset-password')"
										title="Réinitialiser le mot de passe de {{ $userEntry->full_name }}"
										aria-label="Réinitialiser le mot de passe de {{ $userEntry->full_name }}"
										class="bg-primary-700 text-white focus:ring-primary-700"
									>
										<svg
											xmlns="http://www.w3.org/2000/svg"
											fill="none"
											viewBox="0 0 24 24"
											stroke-width="1.5"
											stroke="currentColor"
											class="size-5"
											aria-hidden="true"
										>
											<path
												stroke-linecap="round"
												stroke-linejoin="round"
												d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"
											/>
										</svg>
									</x-action-button>

									@if($userEntry->slug != Auth::user()->slug)
										{{-- Enable / Disable --}}
										@php
											$toggleAccountStateLabel = ($userEntry->trashed() ? 'Activer' : 'Désactiver').' le compte de '.$userEntry->full_name;
										@endphp
										<x-action-button
											wire:click="getUser('{{ $userEntry->slug }}', 'toggle-account')"
											title="{{ $toggleAccountStateLabel }}"
											aria-label="{{ $toggleAccountStateLabel }}"
											class="text-white {{ $userEntry->trashed() ? 'bg-success-700 focus:ring-success-700' : 'bg-danger-700 focus:ring-danger-700' }}"
										>
											@if(!$userEntry->trashed())
												<svg
													xmlns="http://www.w3.org/2000/svg"
													fill="none"
													viewBox="0 0 24 24"
													stroke-width="1.5"
													stroke="currentColor"
													class="size-5"
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
													class="size-5"
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

										{{-- Promoting to admin / Revoking admin --}}
										@php
											$toggleBackOfficeAccessLabel = ($userEntry->can('backoffice.access') ? 'Révoquer l\'accès au back-office' : 'Donner l\'accès au back-office').' à '.$userEntry->full_name;
										@endphp
										<x-action-button
											wire:click="getUser('{{ $userEntry->slug }}', 'toggle-back-office-access')"
											title="{{ $toggleBackOfficeAccessLabel }}"
											aria-label="{{ $toggleBackOfficeAccessLabel }}"
											class="text-white {{ $userEntry->can('backoffice.access') ? 'bg-danger-700 focus:ring-danger-700' : 'bg-success-700 focus:ring-success-700' }}"
										>
											@if($userEntry->can('backoffice.access'))
												<svg
													xmlns="http://www.w3.org/2000/svg"
													fill="none"
													viewBox="0 0 24 24"
													stroke-width="1.5"
													stroke="currentColor"
													class="size-5"
												>
													<path
														stroke-linecap="round"
														stroke-linejoin="round"
														d="M7.498 15.25H4.372c-1.026 0-1.945-.694-2.054-1.715a12.137 12.137 0 0 1-.068-1.285c0-2.848.992-5.464 2.649-7.521C5.287 4.247 5.886 4 6.504 4h4.016a4.5 4.5 0 0 1 1.423.23l3.114 1.04a4.5 4.5 0 0 0 1.423.23h1.294M7.498 15.25c.618 0 .991.724.725 1.282A7.471 7.471 0 0 0 7.5 19.75 2.25 2.25 0 0 0 9.75 22a.75.75 0 0 0 .75-.75v-.633c0-.573.11-1.14.322-1.672.304-.76.93-1.33 1.653-1.715a9.04 9.04 0 0 0 2.86-2.4c.498-.634 1.226-1.08 2.032-1.08h.384m-10.253 1.5H9.7m8.075-9.75c.01.05.027.1.05.148.593 1.2.925 2.55.925 3.977 0 1.487-.36 2.89-.999 4.125m.023-8.25c-.076-.365.183-.75.575-.75h.908c.889 0 1.713.518 1.972 1.368.339 1.11.521 2.287.521 3.507 0 1.553-.295 3.036-.831 4.398-.306.774-1.086 1.227-1.918 1.227h-1.053c-.472 0-.745-.556-.5-.96a8.95 8.95 0 0 0 .303-.54"
													/>
												</svg>
											@else
												<svg
													xmlns="http://www.w3.org/2000/svg"
													fill="none"
													viewBox="0 0 24 24"
													stroke-width="1.5"
													stroke="currentColor"
													class="size-5"
												>
													<path stroke-linecap="round"
														stroke-linejoin="round"
														d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z"
													/>
												</svg>
											@endif
										</x-action-button>
									@endif
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

	{{-- Modal user form --}}
	<x-modal
		name="user-form"
		labelledby="user-form-title"
		focusable
	>
		<section class="p-6 sm:p-8">
			<header>
				<h2 id="user-form-title" class="text-lg font-semibold text-gray-900">
					{{ $user->exists ? 'Modifier l\'utilisateur' : 'Créer un utilisateur' }}
				</h2>
			</header>

			<form wire:submit.prevent="userForm" class="flex flex-col mt-6 space-y-5">
				{{-- Gender --}}
				<fieldset @if($errors->has('gender')) aria-describedby="gender-error" @endif>
					<legend class="block font-medium text-sm text-gray-700">
						Civilité
						<span class="text-danger-600" aria-hidden="true">*</span>
					</legend>

					<div class="mt-2 flex items-center gap-6">
						@foreach(['mr' => 'Mr', 'mme' => 'Mme', 'autre' => 'Autre'] as $value => $label)
							<label class="inline-flex items-center gap-2">
								<input
									type="radio"
									name="gender"
									value="{{ $value }}"
									wire:model="gender"
									class="border-gray-300 text-primary-700 focus:ring-primary-700"
								>
								<span class="text-sm text-gray-700">
									{{ $label }}
								</span>
							</label>
						@endforeach
					</div>

					<x-input-error id="gender-error" :messages="$errors->get('gender')" class="mt-1" />
				</fieldset>

				{{-- First name --}}
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

				{{-- Last name --}}
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

				{{-- Birthday --}}
				<div>
					<x-input-label for="birthday" value="Date de naissance" />
					<x-text-input
						id="birthday"
						type="date"
						wire:model="birthday"
						class="mt-1 block w-full"
						:aria-invalid="$errors->has('birthday') ? 'true' : null"
						:aria-describedby="$errors->has('birthday') ? 'birthday-error' : null"
					/>
					<x-input-error id="birthday-error" :messages="$errors->get('birthday')" class="mt-1" />
				</div>

				{{-- Phone / Mobile --}}
				<div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
					<div>
						<x-input-label for="phone" value="Téléphone" />
						<x-text-input
							id="phone"
							type="tel"
							wire:model="phone"
							class="mt-1 block w-full"
							placeholder="Téléphone"
							:aria-invalid="$errors->has('phone') ? 'true' : null"
							:aria-describedby="$errors->has('phone') ? 'phone-error' : null"
						/>
						<x-input-error id="phone-error" :messages="$errors->get('phone')" class="mt-1" />
					</div>

					<div>
						<x-input-label for="mobile" value="Téléphone portable" />
						<x-text-input
							id="mobile"
							type="tel"
							wire:model="mobile"
							class="mt-1 block w-full"
							placeholder="Téléphone portable"
							:aria-invalid="$errors->has('mobile') ? 'true' : null"
							:aria-describedby="$errors->has('mobile') ? 'mobile-error' : null"
						/>
						<x-input-error id="mobile-error" :messages="$errors->get('mobile')" class="mt-1" />
					</div>
				</div>

				{{-- Role --}}
				<fieldset @if($errors->has('roleSelected')) aria-describedby="role-error" @endif>
					<legend class="block font-medium text-sm text-gray-700">
						Rôle
						<span class="text-danger-600" aria-hidden="true">*</span>
					</legend>

					<div class="mt-2 flex items-center gap-6">
						@foreach($roles as $roleFormEntry)
							<label class="inline-flex items-center gap-2">
								<input
									type="radio"
									name="role"
									value="{{ $roleFormEntry->name }}"
									wire:model="roleSelected"
									class="border-gray-300 text-primary-700 focus:ring-primary-700"
								>
								<span class="text-sm text-gray-700">
									{{ ucfirst($roleFormEntry->name) }}
								</span>
							</label>
						@endforeach
					</div>

					@if($isUserManagerOfAService)
						<div class="mt-2 text-sm text-gray-400">
							{{ $user->full_name }} est chef de service pour un ou plusieurs services.
							Changer son rôle {{ $user->gender == 'mr' ? 'le' : 'la' }} supprimera des services auxquels {{ $user->gender == 'mr' ? 'il est associé' : 'elle est associée' }}.
						</div>
					@endif

					<x-input-error id="role-error" :messages="$errors->get('roleSelected')" class="mt-1" />
				</fieldset>

				{{-- Service --}}
				<div>
					<x-input-label for="service" value="Service" />
					<x-select-input
						id="service"
						wire:model="serviceSelected"
						class="mt-1 block w-full"
						:aria-invalid="$errors->has('serviceSelected') ? 'true' : null"
						:aria-describedby="$errors->has('serviceSelected') ? 'service-error' : null"
					>
						<option value="">Aucun service</option>
						@foreach($services as $serviceFormEntry)
							<option value="{{ $serviceFormEntry->slug }}">
								{{ $serviceFormEntry->name }}
							</option>
						@endforeach
					</x-select-input>
					<x-input-error id="service-error" :messages="$errors->get('serviceSelected')" class="mt-1" />
				</div>

				{{-- Manager --}}
				<div>
					<x-input-label for="manager" value="Chef de service" />
					<x-select-input
						id="manager"
						wire:model="managerSelected"
						class="mt-1 block w-full"
						:aria-invalid="$errors->has('managerSelected') ? 'true' : null"
						:aria-describedby="$errors->has('managerSelected') ? 'manager-error' : null"
					>
						<option value="">Aucun chef de service</option>
						@foreach($managers as $managerFormEntry)
							<option value="{{ $managerFormEntry->slug }}">
								{{ $managerFormEntry->full_name }}
							</option>
						@endforeach
					</x-select-input>
					<x-input-error id="manager-error" :messages="$errors->get('managerSelected')" class="mt-1" />
				</div>

				{{-- Contract type --}}
				<div>
					<x-input-label for="contract-type" value="Type de contrat" :required="true" />
					<x-select-input
						id="contract-type"
						wire:model="contractTypeSelected"
						class="mt-1 block w-full"
						:aria-invalid="$errors->has('contractTypeSelected') ? 'true' : null"
						:aria-describedby="$errors->has('contractTypeSelected') ? 'contract-type-error' : null"
					>
						<option value="">Aucun type de contrat</option>
						@foreach($contractTypes as $contractTypeFormEntry)
							<option value="{{ $contractTypeFormEntry->id }}">
								{{ $contractTypeFormEntry->name }}
							</option>
						@endforeach
					</x-select-input>
					<x-input-error id="contract-type-error" :messages="$errors->get('contractTypeSelected')" class="mt-1" />
				</div>

				{{-- Work schedule --}}
				<div>
					<x-input-label for="work-schedule" value="Régime de travail" :required="true" />
					<x-select-input
						id="work-schedule"
						wire:model="workScheduleSelected"
						class="mt-1 block w-full"
						:aria-invalid="$errors->has('workScheduleSelected') ? 'true' : null"
						:aria-describedby="$errors->has('workScheduleSelected') ? 'work-schedule-error' : null"
					>
						<option value="">Aucun régime de travail</option>
						@foreach($workSchedules as $workScheduleFormEntry)
							<option value="{{ $workScheduleFormEntry->id }}">
								{{ $workScheduleFormEntry->name }}
							</option>
						@endforeach
					</x-select-input>
					<x-input-error id="work-schedule-error" :messages="$errors->get('workScheduleSelected')" class="mt-1" />
				</div>

				{{-- Buttons --}}
				<div class="flex flex-col-reverse gap-3 pt-2 sm:flex-row sm:justify-end">
					<x-cancel-button />

					<x-validate-button @user-form-complete.window="$dispatch('close')">
						{{ $user->exists ? 'Modifier l\'utilisateur' : 'Créer l\'utilisateur' }}
					</x-validate-button>
				</div>
			</form>
		</section>
	</x-modal>

	{{-- Modal user disabling / enabling --}}
	<x-modal
		name="toggle-account"
		labelledby="toggle-account-title"
		focusable
	>
		<section class="p-6 sm:p-8">
			<header>
				<h2 id="toggle-account-title" class="text-lg font-semibold text-gray-900">
					{{ $accountState }} ?
				</h2>

				<p class="mt-2 text-sm text-gray-500">
					Cette action modifiera l'état du compte utilisateur.
				</p>
			</header>

			<form wire:submit.prevent="toggleUser">
				<div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
					<x-cancel-button />

					<x-validate-button @account-toggled.window="$dispatch('close');">
						{{ $accountState }}
					</x-validate-button>
				</div>
			</form>
		</section>
	</x-modal>

	{{-- Modal give / revoke back-office access --}}
	<x-modal
		name="toggle-back-office-access"
		labelledby="toggle-back-office-access-title"
		focusable
	>
		<section class="p-6 sm:p-8">
			<header>
				<h2 id="toggle-back-office-access-title" class="text-lg font-semibold text-gray-900">
					{{ $backOfficeAccessState }} ?
				</h2>

				<p class="mt-2 text-sm text-gray-500">
					Cette action modifiera l'état du compte utilisateur.
				</p>
			</header>

			<form wire:submit.prevent="toggleBackOfficeAccess">
				<div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
					<x-cancel-button />

					<x-validate-button @back-office-access-toggled.window="$dispatch('close');">
						{{ $backOfficeAccessState }}
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
					L'utilisateur recevra un email lui permettant de définir un nouveau mot de passe.
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