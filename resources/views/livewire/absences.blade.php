<div class="p-6 text-gray-900">
	<header class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-8">
		<div>
			<h2 class="text-xl font-semibold text-gray-800">
				@if($user->slug != Auth::user()->slug)
					Les temps de {{ $user->full_name }}
				@else
					Mes temps
				@endif
			</h2>

			<p class="mt-1 text-sm text-gray-600">
				Suivi {{ $user->slug != Auth::user()->slug ? 'des' : 'de votre' }} temps de travail pour la semaine en cours.
			</p>
		</div>

		<div class="flex flex-row gap-x-2 items-end justify-center">
			@role('chef de service')
				<div>
					<x-input-label for="users-filter" value="Voir les temps d'un agent" />

					<x-select-input
						id="users-filter"
						wire:model.live="filterUserSelected"
						class="mt-1 block w-full"
						:aria-invalid="$errors->has('filterUserSelected') ? 'true' : null"
						:aria-describedby="$errors->has('filterUserSelected') ? 'users-filter' : null"
					>
						<option value="">Aucun agent</option>
						@foreach($users as $userFiltersEntry)
							<option value="{{ $userFiltersEntry->slug }}">
								{{ $userFiltersEntry->full_name }}
							</option>
						@endforeach
					</x-select-input>
				</div>
			@endrole

			<x-primary-button
				wire:click="fresh"
				x-on:click.prevent="$dispatch('open-modal', 'absence-form');"
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

				Faire une demande
			</x-primary-button>

			{{-- Modal absence form --}}
			<x-modal
				name="absence-form"
				labelledby="absence-form-title"
				focusable
			>
				<section class="p-6 sm:p-8">
					<header>
						<h2 id="absence-form-title" class="text-lg font-semibold text-gray-900">
							Formulaire de demande
						</h2>

						<p class="mt-1 text-sm text-gray-600">
							Choisissez le type de demande et la période concernée.
						</p>
					</header>

					<form wire:submit="absenceForm" class="mt-6 space-y-6">
						{{-- Type + solde --}}
						<div class="space-y-3">
							<div>
								<x-input-label for="type" value="Type de demande" :required="true" />
								<x-select-input
									id="type"
									wire:model.live="typeSelected"
									class="mt-1 block w-full"
									:aria-invalid="$errors->has('typeSelected') ? 'true' : null"
									:aria-describedby="$errors->has('typeSelected') ? 'type-error' : null"
								>
									<option value="">Sélectionnez un type de demande</option>
									@foreach(App\Enums\AbsenceType::cases() as $absenceTypeFormEntry)
										<option value="{{ $absenceTypeFormEntry->value }}">
											{{ $absenceTypeFormEntry->label() }}
										</option>
									@endforeach
								</x-select-input>
								<x-input-error id="type-error" :messages="$errors->get('typeSelected')" class="mt-1" />
							</div>

							<div aria-live="polite">
								@if($balance)
									<div class="flex items-center justify-between rounded-lg bg-gray-50 px-4 py-3 text-sm">
										<span class="text-gray-600">Solde disponible</span>
										<span class="font-semibold text-gray-900">{{ $balance->formatted }}</span>
									</div>
								@endif
								<x-input-error :messages="$errors->get('balance')" class="mt-1" />
							</div>
						</div>

						{{-- Début --}}
						<fieldset>
							<legend class="text-sm font-semibold text-gray-900">Début</legend>
							<div class="mt-2 grid grid-cols-1 gap-4 sm:grid-cols-2">
								<div>
									<x-input-label for="start" value="Date" :required="true" />
									<x-text-input
										id="start"
										type="date"
										wire:model.live="start"
										class="mt-1 block w-full"
										:aria-invalid="$errors->has('start') ? 'true' : null"
										:aria-describedby="$errors->has('start') ? 'start-error' : null"
									/>
									<x-input-error id="start-error" :messages="$errors->get('start')" class="mt-1" />
								</div>

								<div>
									<x-input-label for="start-period" value="Période" :required="true" />
									<x-select-input
										id="start-period"
										wire:model.live="startPeriodSelected"
										class="mt-1 block w-full"
										:aria-invalid="$errors->has('startPeriodSelected') ? 'true' : null"
										:aria-describedby="$errors->has('startPeriodSelected') ? 'start-period-error' : null"
									>
										@foreach(App\Enums\AbsencePeriod::cases() as $absencePeriodFormEntry)
											<option value="{{ $absencePeriodFormEntry->value }}">
												{{ $absencePeriodFormEntry->label() }}
											</option>
										@endforeach
									</x-select-input>
									<x-input-error id="start-period-error" :messages="$errors->get('startPeriodSelected')" class="mt-1" />
								</div>
							</div>
						</fieldset>

						{{-- Fin --}}
						<fieldset>
							<legend class="text-sm font-semibold text-gray-900">Fin</legend>
							<div class="mt-2 grid grid-cols-1 gap-4 sm:grid-cols-2">
								<div>
									<x-input-label for="end" value="Date" :required="true" />
									<x-text-input
										id="end"
										type="date"
										wire:model.live="end"
										:min="$start ?: null"
										class="mt-1 block w-full"
										:aria-invalid="$errors->has('end') ? 'true' : null"
										:aria-describedby="$errors->has('end') ? 'end-error' : null"
									/>
									<x-input-error id="end-error" :messages="$errors->get('end')" class="mt-1" />
								</div>

								<div>
									<x-input-label for="end-period" value="Période" :required="true" />
									<x-select-input
										id="end-period"
										wire:model.live="endPeriodSelected"
										class="mt-1 block w-full"
										:aria-invalid="$errors->has('endPeriodSelected') ? 'true' : null"
										:aria-describedby="$errors->has('endPeriodSelected') ? 'end-period-error' : null"
									>
										@foreach(App\Enums\AbsencePeriod::cases() as $absencePeriodFormEntry)
											<option value="{{ $absencePeriodFormEntry->value }}">
												{{ $absencePeriodFormEntry->label() }}
											</option>
										@endforeach
									</x-select-input>
									<x-input-error id="end-period-error" :messages="$errors->get('endPeriodSelected')" class="mt-1" />
								</div>
							</div>
						</fieldset>

						{{-- Boutons --}}
						<div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-5 sm:flex-row sm:justify-end">
							<x-cancel-button />

							<x-validate-button
								wire:loading.attr="disabled"
								wire:target="absenceForm"
								@absence-form-complete.window="$dispatch('close')"
							>
								Finaliser ma demande
							</x-validate-button>
						</div>
					</form>
				</section>
			</x-modal>
		</div>
	</header>

	{{-- Navigation buttons --}}
	<div class="flex flex-row items-center justify-between mb-8">
		<x-primary-button
			type="button"
			wire:click="previousMonth"
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
				d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18"
			/>
			</svg>

			Mois précédent
		</x-primary-button>

		<x-primary-button
			type="button"
			wire:click="nextMonth"
		>
			Mois suivant

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
				d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3"
			/>
			</svg>
		</x-primary-button>
	</div>

	{{-- Summary of the week --}}
	<section aria-labelledby="week-summary-title" class="mb-8">
		<div class="mb-4">
			<h3
				id="week-details-title"
				class="text-lg font-semibold text-gray-800"
			>
				Compteurs
			</h3>
		</div>

		<div class="grid gap-4 sm:grid-cols-3">
			{{-- Time achieved --}}
			<div class="rounded-lg border border-gray-200 p-5">
				<p class="text-sm font-medium text-gray-600">
					Congés
				</p>

				<p class="mt-2 text-2xl font-semibold text-gray-900">
					{{ $user->dayOffBalance->formatted }}
				</p>
			</div>

			{{-- Expected time --}}
			<div class="rounded-lg border border-gray-200 p-5">
				<p class="text-sm font-medium text-gray-600">
					Récupération
				</p>

				<p class="mt-2 text-2xl font-semibold text-gray-900">
					{{ $user->recoveryBalance->formatted }}
				</p>
			</div>
		</div>
	</section>

	{{-- Month Detail --}}
	<section aria-labelledby="week-details-title">
		<div class="mb-4">
			<h3
				id="week-details-title"
				class="text-lg font-semibold text-gray-800"
			>
				
			</h3>
		</div>

		
	</section>
</div>