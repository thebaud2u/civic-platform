<div class="w-full space-y-6">
	<div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
		<div>
			Gérer les services de la mairie
		</div>

		<button
			type="button"
			x-data
			x-on:click="$dispatch('open-modal', 'service-form')"
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

			Créer un service
		</button>
	</div>

	{{-- Filtres --}}
	<div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
		<div class="flex flex-col gap-4 sm:flex-row sm:items-end">
			{{-- Rôle --}}
			<div class="w-full sm:w-auto sm:min-w-52">
				<label for="manager-filter" class="mb-1.5 block text-sm font-medium text-gray-700">
					Chef de service
				</label>

				<select
					id="manager-filter"
					wire:model.live="manager"
					class="block w-full rounded-md border-gray-300 text-sm shadow-sm
						   focus:border-primary-700 focus:ring-primary-700"
				>
					<option value="">Tous les chefs de service</option>

					@foreach($managers as $managerFilterEntry)
						<option value="{{ $managerFilterEntry->slug }}">
							{{ ucfirst($managerFilterEntry->name) }}
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
						placeholder="Nom, chef de service..."
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
							{{-- Utilisateur --}}
							<td class="px-6 py-4">
								<div class="flex items-center gap-3">
									{{ $serviceEntry->name }}
								</div>
							</td>

							{{-- Manager --}}
							<td class="px-6 py-4 text-sm text-gray-700">
								{{ $serviceEntry->manager?->fullName() ?? '—' }}
							</td>

							{{-- Actions --}}
							<td class="px-6 py-4">
								<div class="flex justify-end gap-2">
									<button
										type="button"
										wire:click="getService('{{ $serviceEntry->slug }}', 'service-form')"
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

	<x-modal
		name="service-form"
		:class="'w-full max-w-2xl'"
		focusable
	>
		<section class="p-6 sm:p-8">
			<header>
				<h2 class="text-lg font-semibold text-gray-900">
					{{ $service->exists ? 'Modifier le service' : 'Créer un service' }}
				</h2>
			</header>

			<form wire:submit.prevent="serviceForm" class="flex flex-col mt-6 space-y-5">
				{{-- Name --}}
				<div>
					<label for="name" class="block text-sm font-medium text-gray-700">
						Libellé du service
					</label>

					<input
						type="text"
						id="name"
						wire:model="name"
						class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
							focus:border-mnw-deepblue focus:ring-mnw-deepblue"
					>

					@error('name')
						<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
					@enderror
				</div>

				<div>
					<label for="description" class="block text-sm font-medium text-gray-700">
						Description
					</label>

					<input
						type="text"
						id="description"
						wire:model="description"
						class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
							focus:border-mnw-deepblue focus:ring-mnw-deepblue"
					>

					@error('description')
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

					<x-primary-button type="submit" @service-form-complete.window="$dispatch('close')">
						{{ $service->exists ? 'Modifier le service' : 'Créer un service' }}
					</x-primary-button>
				</div>
			</form>
		</section>
	</x-modal>
</div>