<div class="w-full space-y-6">
	<div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
		<div>
			Gérer les services de la mairie
		</div>

		<x-primary-button
			wire:click="fresh"
			x-on:click.prevent="$dispatch('open-modal', 'service-form');"
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

			Créer un service
		</x-primary-button>
	</div>

	{{-- Filtres --}}
	<div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
		<div class="flex flex-col gap-4 sm:flex-row sm:items-end">
			{{-- Manager --}}
			<div class="w-full sm:w-auto sm:min-w-52">
				<x-input-label for="manager-filter" value="Chef de service" />
				<x-select-input
					id="manager-filter"
					wire:model="manager"
					class="mt-1 block w-full"
				>
					<option value="">Tous les chefs de service</option>
					@foreach($managers as $managerFilterEntry)
						<option value="{{ $managerFilterEntry->slug }}">
							{{ $managerFilterEntry->full_name }}
						</option>
					@endforeach
				</x-select-input>
			</div>

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
						placeholder="Nom, chef de service..."
					/>
				</div>
			</div>
		</div>
	</div>

	{{-- Table --}}
	<div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
		<div class="overflow-x-auto">
			<table class="w-full min-w-[900px]">
				<caption class="sr-only">Liste des services</caption>

				<thead class="bg-gray-50">
					<tr>
						<th scope="col"
							class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
							Nom
						</th>

						<th scope="col"
							class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
							Chef de service
						</th>

						<th scope="col"
							class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
							Actions
						</th>
					</tr>
				</thead>

				<tbody class="divide-y divide-gray-200">
					@forelse($services as $serviceEntry)
						<tr class="transition-colors hover:bg-gray-50">
							{{-- Name --}}
							<td class="px-6 py-4">
								{{ $serviceEntry->name }}
							</td>

							{{-- Manager --}}
							<td class="px-6 py-4 text-sm text-gray-700">
								{{ $serviceEntry->manager?->full_name ?? '—' }}
							</td>

							{{-- Actions --}}
							<td class="px-6 py-4">
								<div class="flex justify-end gap-2">
									{{-- Update service --}}
									<x-action-button
										wire:click="getService('{{ $serviceEntry->slug }}', 'service-form')"
										title="Modifier le service {{ $serviceEntry->name }}"
										aria-label="Modifier le service {{ $serviceEntry->name }}"
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

									{{-- Delete service --}}
									<x-action-button
										wire:click="getService('{{ $serviceEntry->slug }}', 'delete-form')"
										title="Supprimer le service {{ $serviceEntry->name }}"
										aria-label="Supprimer le service {{ $serviceEntry->name }}"
										class="bg-danger-700 text-white focus:ring-danger-700"
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
												d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
											/>
										</svg>
									</x-action-button>
								</div>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="3" class="px-6 py-12 text-center">
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
										Aucun service ne correspond aux critères de recherche.
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
	@if($services->hasPages())
		<div class="rounded-lg border border-gray-200 bg-white px-4 py-3 shadow-sm sm:px-6">
			{{ $services->links() }}
		</div>
	@endif

	{{-- Modal service form --}}
	<x-modal
		name="service-form"
		labelledby="service-form-title"
		focusable
	>
		<section class="p-6 sm:p-8">
			<header>
				<h2 id="service-form-title" class="text-lg font-semibold text-gray-900">
					{{ $service->exists ? 'Modifier le service' : 'Créer un service' }}
				</h2>
			</header>

			<form wire:submit.prevent="serviceForm" class="flex flex-col mt-6 space-y-5">
				{{-- Name --}}
				<div>
					<x-input-label for="name" value="Libellé du service" :required="true" />
					<x-text-input
						id="name"
						type="text"
						wire:model="name"
						class="mt-1 block w-full"
						placeholder="Libellé du service"
						aria-required="true"
						:aria-invalid="$errors->has('name') ? 'true' : null"
						:aria-describedby="$errors->has('name') ? 'name-error' : null"
					/>
					<x-input-error id="name-error" :messages="$errors->get('name')" class="mt-1" />
				</div>

				{{-- Description --}}
				<div>
					<x-input-label for="description" value="Description du service" />
					<x-text-input
						id="description"
						type="text"
						wire:model="description"
						class="mt-1 block w-full"
						placeholder="Description du service"
						:aria-invalid="$errors->has('description') ? 'true' : null"
						:aria-describedby="$errors->has('description') ? 'description-error' : null"
					/>
					<x-input-error id="description-error" :messages="$errors->get('description')" class="mt-1" />
				</div>

				{{-- Manager --}}
				<div>
					<x-input-label for="manager" value="Chef du service" />
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

				{{-- Boutons --}}
				<div class="flex flex-col-reverse gap-3 pt-2 sm:flex-row sm:justify-end">
					<x-cancel-button />

					<x-validate-button @service-form-complete.window="$dispatch('close')">
						{{ $service->exists ? 'Modifier le service' : 'Créer un service' }}
					</x-validate-button>
				</div>
			</form>
		</section>
	</x-modal>

	{{-- Modal delete form --}}
	<x-modal
		name="delete-form"
		labelledby="delete-form-title"
		focusable
	>
		<section class="p-6 sm:p-8">
			<header>
				<h2 id="delete-form-title" class="text-lg font-semibold text-gray-900">
					Supprimer le service {{ $service->exists ? $service->name : '' }} ?
				</h2>
			</header>

			<form wire:submit.prevent="deleteForm">
				<div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
					<x-cancel-button />

					<x-validate-button @service-deleted.window="$dispatch('close');">
						Supprimer le service
					</x-validate-button>
				</div>
			</form>
		</section>
	</x-modal>
</div>