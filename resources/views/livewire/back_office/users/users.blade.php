<div>
	<div class="mb-5 text-sm sm:text-base lg:text-xl">
		<div class="flex flex-wrap items-center gap-4">
			<select id="role" wire:model.live="role" class="block mt-1 border border-gray-300 focus:border-mnw-deepblue focus:ring-mnw-deepblue rounded-md shadow-sm">
				<option value="">Sélectionnez un rôle</option>
				@foreach($roles as $role)
					<option value="{{ $role->id }}">
						{{ __($role->name) }}
					</option>
				@endforeach
			</select>

			<div class="bg-white border-b border-gray-400 shadow-md px-2 py-1 lg:p-0 text-gray-400 min-w-[250px]">
				<div class="relative mt-1 border-b-4 border-transparent">
					<div class="absolute inset-y-0 left-1 lg:left-2 flex items-center pointer-events-none">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
						</svg>
					</div>
					<input type="text" wire:model.live="keyword" name="keyword" id="keyword" placeholder="'Mot(s) clé(s) : nom, email, ...'" class="block w-full p-1.5 pl-8 lg:pl-9 text-gray-500 text-sm xl:text-base bg-white border border-transparent focus:border-transparent focus:ring-0 rounded-md" />
				</div>
			</div>
		</div>
	</div>

	<div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
		<div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
			<table class="min-w-full">
				<thead>
					<tr>
						<th class="px-6 py-3 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">Nom</th>
						<th class="px-6 py-3 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">Rôle</th>
						<th class="px-6 py-3 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">Service</th>
						<th class="px-6 py-3 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">Manager</th>
						<th class="px-6 py-3 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">Dernière connexion</th>
						<th class="px-6 py-3 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 tracking-wider">Action</th>
					</tr>
				</thead>

				<tbody class="bg-white">
					@if($users->isNotEmpty())
						@foreach($users as $userEntry)
							<tr>
								<td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
									<div class="flex items-center">
										<div class="text-sm leading-5 font-medium text-gray-900">{{ $userEntry->fullName() }}</div>
										<div class="text-sm leading-5 text-gray-500">{{ $userEntry->email }}</div>
									</div>
								</td>

								<td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
									@if($userEntry->roles->isNotEmpty())
										<button type="button"
											@if($userEntry->hasRole('agent'))
												class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-3 py-2.5 text-center me-2 mb-2 mr-2 mb-2"
											@elseif($userEntry->hasRole('manager'))
												class="text-white bg-gradient-to-br from-pink-500 to-orange-400 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800 font-medium rounded-lg text-sm px-3 py-2.5 text-center mr-2 mb-2"
											@endif
										>
											{{ __($userEntry->getRoleNames()[0]) }}
										</button>
									@else
										{{ __('User has no role') }}
									@endif
								</td>

								<td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
									{{ $userEntry->service->name }}
								</td>

								<td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
									{{ $userEntry->manager?->fullname() }}
								</td>

								<td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
									{{ $userEntry->last_logon?->format('d/m/Y H:i:s') }}
								</td>

								<td class="px-6 py-4 whitespace-no-wrap text-left border-b border-gray-200 text-sm leading-5 font-medium">
									<button type="button" wire:click="getUser({{ $userEntry->id }}, 'reset-password')" title="{{ __('Reset the user\'s password and send it to him by email') }}" class="text-gray-900 bg-gradient-to-r from-teal-200 to-lime-200 hover:bg-gradient-to-l hover:from-teal-200 hover:to-lime-200 focus:ring-4 focus:outline-none focus:ring-lime-200 dark:focus:ring-teal-700 font-medium rounded-lg text-sm px-3 py-2.5 text-center me-2 mb-2">
										<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
											<path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
										</svg>
									</button>

									<button type="button" wire:click="getUser({{ $userEntry->id }}, 'toggle-account')" title="{{ !$userEntry->trashed() ? 'Désactiver le compte' : 'Activer le compte' }}" class="text-white bg-gradient-to-br from-pink-500 to-orange-400 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800 font-medium rounded-lg text-sm px-3 py-2.5 text-center me-2 mb-2">
										@if(!$userEntry->trashed())
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
												<path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
											</svg>
										@else
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
												<path stroke-linecap="round" stroke-linejoin="round" d="m9 9 6-6m0 0 6 6m-6-6v12a6 6 0 0 1-12 0v-3" />
											</svg>
										@endif
									</button>
								</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td colspan="5" class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-center">
								Aucun résultat pour cette recherche
							</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>

	<div class="mt-8 px-5 py-6 bg-white shadow-sm rounded-md">
		{{ $users->links() }}
	</div>

	<x-front.modal name="toggle-account" :class="'w-full max-w-2xl'" focusable>
		<section class="p-10 flex flex-col flex-wrap content-center">
			<header class="flex flex-col flex-wrap content-center">
				<h2 class="text-lg font-semibold">
					{{ $switchState }} ?
				</h2>
			</header>

			<div class="mt-6 flex flex-row flex-wrap justify-center">
				<x-front.secondary-button x-on:click="$dispatch('close');" :class="'mr-6'">
					Annuler
				</x-front.secondary-button>

				<x-front.primary-button wire:click="toggleUser" @account-toggled.window="$dispatch('close');">
					{{ $switchState }}
				</x-front.primary-button>
			</div>
		</section>
	</x-front.modal>

	<x-front.modal name="reset-password" :class="'w-full max-w-2xl'" focusable>
		<section class="p-10 flex flex-col flex-wrap content-center">
			<header class="flex flex-col flex-wrap content-center">
				<h2 class="text-lg font-semibold">
					Réinitialiser le mot de passe de l'utilisateur ?
				</h2>
			</header>

			<p class="text-sm text-gray">
				L'utilisateur recevra un email lui permettant de définir un nouveau mot de passe.
			</p>

			<div class="mt-6 flex flex-row flex-wrap justify-center">
				<x-front.secondary-button x-on:click="$dispatch('close');" :class="'mr-6'">
					Annuler
				</x-front.secondary-button>

				<x-front.primary-button wire:click="resetPassword" @password-changed.window="$dispatch('close');">
					{{ __('Reset password') }}
				</x-front.primary-button>
			</div>
		</section>
	</x-front.modal>
</div>
