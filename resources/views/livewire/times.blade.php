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

		@role('chef de service')
			<div class="flex flex-row gap-x-2 items-end justify-center">
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

				<x-primary-button
					wire:click="fresh"
					x-on:click.prevent="$dispatch('open-modal', 'fix-anomaly-form');"
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

					Corriger une anomalie
				</x-primary-button>
			</div>

			{{-- Modal fix anomaly form --}}
			<x-modal
				name="fix-anomaly-form"
				labelledby="fix-anomaly-form-title"
				focusable
			>
				<section class="p-6 sm:p-8">
					<header>
						<h2 id="fix-anomaly-form-title" class="text-lg font-semibold text-gray-900">
							Corriger une anomalie
						</h2>
					</header>

					<form wire:submit.prevent="anomalyForm" class="flex flex-col mt-6 space-y-5">
						{{-- Date --}}
						<div>
							<x-input-label for="date" value="Date" :required="true" />
							<x-text-input
								id="date"
								type="datetime-local"
								wire:model="date"
								class="mt-1 block w-full"
								:aria-invalid="$errors->has('date') ? 'true' : null"
								:aria-describedby="$errors->has('date') ? 'date-error' : null"
							/>
							<x-input-error id="date-error" :messages="$errors->get('date')" class="mt-1" />
						</div>

						{{-- Way --}}
						<fieldset @if($errors->has('way')) aria-describedby="way-error" @endif>
							<legend class="block font-medium text-sm text-gray-700">
								Type
								<span class="text-danger-600" aria-hidden="true">*</span>
							</legend>

							<div class="mt-2 flex items-center gap-6">
								@foreach(['in' => 'Entrée', 'out' => 'Sortie'] as $value => $label)
									<label class="inline-flex items-center gap-2">
										<input
											type="radio"
											name="way"
											value="{{ $value }}"
											wire:model="way"
											class="border-gray-300 text-primary-700 focus:ring-primary-700"
										>
										<span class="text-sm text-gray-700">
											{{ $label }}
										</span>
									</label>
								@endforeach
							</div>

							<x-input-error id="way-error" :messages="$errors->get('way')" class="mt-1" />
						</fieldset>

						{{-- Users --}}
						<div>
							<x-input-label for="user" value="Agent" :required="true" />
							<x-select-input
								id="user"
								wire:model="userSelected"
								class="mt-1 block w-full"
								:aria-invalid="$errors->has('userSelected') ? 'true' : null"
								:aria-describedby="$errors->has('userSelected') ? 'user-error' : null"
							>
								<option value="">Aucun agent</option>
								@foreach($users as $userFormEntry)
									<option value="{{ $userFormEntry->slug }}">
										{{ $userFormEntry->full_name }}
									</option>
								@endforeach
							</x-select-input>
							<x-input-error id="user-error" :messages="$errors->get('userSelected')" class="mt-1" />
						</div>

						{{-- Buttons --}}
						<div class="flex flex-col-reverse gap-3 pt-2 sm:flex-row sm:justify-end">
							<x-cancel-button />

							<x-validate-button @anomaly-form-complete.window="$dispatch('close')">
								Corriger l'anomalie
							</x-validate-button>
						</div>
					</form>
				</section>
			</x-modal>
		@endrole
	</header>

	{{-- Navigation buttons --}}
	<div class="flex flex-row items-center justify-between mb-8">
		<x-primary-button
			type="button"
			wire:click="previousWeek"
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

			Semaine précédente
		</x-primary-button>

		<x-primary-button
			type="button"
			wire:click="nextWeek"
		>
			Semaine suivante

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
				Résumé de la semaine {{ $weekNumber }} de {{ $year }}
			</h3>
		</div>

		<div class="grid gap-4 sm:grid-cols-3">
			{{-- Time achieved --}}
			<div class="rounded-lg border border-gray-200 p-5">
				<p class="text-sm font-medium text-gray-600">
					Temps réalisé
				</p>

				<p class="mt-2 text-2xl font-semibold text-gray-900">
					{{ intdiv($weeklyTimeSummary['total'], 60) }}h{{ str_pad($weeklyTimeSummary['total'] % 60, 2, '0', STR_PAD_LEFT) }}
				</p>
			</div>

			@if($weeklyTimeSummary['is_hourly'])
				{{-- Expected time --}}
				<div class="rounded-lg border border-gray-200 p-5">
					<p class="text-sm font-medium text-gray-600">
						Temps attendu
					</p>

					<p class="mt-2 text-2xl font-semibold text-gray-900">
						{{ $user->workSchedule->weekly_hours }}h
					</p>
				</div>

				{{-- Difference --}}
				<div class="rounded-lg border border-gray-200 p-5">
					<p class="text-sm font-medium text-gray-600">
						Écart
					</p>

					<p class="mt-2 text-2xl font-semibold text-gray-900">
						@if($weeklyTimeSummary['difference'] > 0)
							+{{ intdiv($weeklyTimeSummary['difference'], 60) }}h{{ str_pad($weeklyTimeSummary['difference'] % 60, 2, '0', STR_PAD_LEFT) }}
						@elseif($weeklyTimeSummary['difference'] < 0)
							-{{ intdiv(abs($weeklyTimeSummary['difference']), 60) }}h{{ str_pad(abs($weeklyTimeSummary['difference']) % 60, 2, '0', STR_PAD_LEFT) }}
						@else
							0h00
						@endif
					</p>
				</div>
			@else
				{{-- Plan --}}
				<div class="rounded-lg border border-gray-200 p-5 sm:col-span-2">
					<p class="text-sm font-medium text-gray-600">
						Régime de travail
					</p>

					<p class="mt-2 text-2xl font-semibold text-gray-900">
						Au forfait
					</p>
				</div>
			@endif
		</div>
	</section>

	{{-- Week Detail --}}
	<section aria-labelledby="week-details-title">
		<div class="mb-4">
			<h3
				id="week-details-title"
				class="text-lg font-semibold text-gray-800"
			>
				Détail de la semaine
			</h3>
		</div>

		@if(count($weeklyTimeSummary['days']) > 0)
			<div class="overflow-x-auto">
				<table class="w-full text-left text-sm text-gray-600">
					<caption class="sr-only">
						Détail du temps de travail pour chaque journée de la semaine
					</caption>

					<thead class="border-b border-gray-200 text-xs uppercase text-gray-500">
						<tr>
							<th scope="col" class="px-4 py-3">
								Jour
							</th>

							<th scope="col" class="px-4 py-3">
								Périodes
							</th>

							<th scope="col" class="px-4 py-3">
								Durée
							</th>

							@if($weeklyTimeSummary['is_hourly'])
								<th scope="col" class="px-4 py-3">
									Écart
								</th>
							@endif
						</tr>
					</thead>

					<tbody class="divide-y divide-gray-200">
						@foreach($weeklyTimeSummary['days'] as $day)
							<tr>
								{{-- Day --}}
								<th
									scope="row"
									class="px-4 py-4 font-medium text-gray-900 whitespace-nowrap align-top"
								>
									{{ $day['date']->translatedFormat('l d/m') }}
								</th>

								{{-- Periods --}}
								<td class="px-4 py-4 align-top">
									@if(count($day['pairs']) > 0)
										<ul class="space-y-1">
											@foreach($day['pairs'] as $pair)
												<li class="whitespace-nowrap">
													{{ $pair['in']->date->format('H:i') }}
													<span aria-hidden="true">→</span>
													{{ $pair['out']->date->format('H:i') }}
												</li>
											@endforeach
										</ul>
									@else
										<span class="text-gray-500">
											—
										</span>
									@endif

									@if($day['has_anomaly'])
										<p class="mt-2 font-medium text-red-700">
											Attention : badgeage incomplet ou incohérent.
										</p>
									@endif
								</td>

								{{-- Duration --}}
								<td class="px-4 py-4 font-medium text-gray-900 whitespace-nowrap align-top">
									{{ intdiv($day['minutes'], 60) }}h{{ str_pad($day['minutes'] % 60, 2, '0', STR_PAD_LEFT) }}
								</td>

								@if($weeklyTimeSummary['is_hourly'])
									{{-- Difference --}}
									<td class="px-4 py-4 whitespace-nowrap align-top">
										@if($day['difference'] > 0)
											<span class="font-medium text-green-700">
												+{{ intdiv($day['difference'], 60) }}h{{ str_pad($day['difference'] % 60, 2, '0', STR_PAD_LEFT) }}
											</span>
										@elseif($day['difference'] < 0)
											<span class="font-medium text-red-700">
												-{{ intdiv(abs($day['difference']), 60) }}h{{ str_pad(abs($day['difference']) % 60, 2, '0', STR_PAD_LEFT) }}
											</span>
										@else
											<span class="font-medium text-gray-900">
												0h00
											</span>
										@endif
									</td>
								@endif
							</tr>
						@endforeach
					</tbody>

					<tfoot class="border-t border-gray-300">
						<tr>
							<th
								scope="row"
								@if($weeklyTimeSummary['is_hourly'])
									colspan="2"
								@endif
								class="px-4 py-4 text-right font-semibold text-gray-900"
							>
								Total
							</th>

							<td class="px-4 py-4 font-semibold text-gray-900">
								{{ intdiv($weeklyTimeSummary['total'], 60) }}h{{ str_pad($weeklyTimeSummary['total'] % 60, 2, '0', STR_PAD_LEFT) }}
							</td>

							@if($weeklyTimeSummary['is_hourly'])
								<td class="px-4 py-4 font-semibold text-gray-900">
									@if($weeklyTimeSummary['difference'] > 0)
										+{{ intdiv($weeklyTimeSummary['difference'], 60) }}h{{ str_pad($weeklyTimeSummary['difference'] % 60, 2, '0', STR_PAD_LEFT) }}
									@elseif($weeklyTimeSummary['difference'] < 0)
										-{{ intdiv(abs($weeklyTimeSummary['difference']), 60) }}h{{ str_pad(abs($weeklyTimeSummary['difference']) % 60, 2, '0', STR_PAD_LEFT) }}
									@else
										0h00
									@endif
								</td>
							@endif
						</tr>
					</tfoot>
				</table>
			</div>
		@else
			<div class="rounded-lg border border-dashed border-gray-300 p-8 text-center">
				<p class="text-sm text-gray-600">
					Aucun temps enregistré pour cette semaine.
				</p>
			</div>
		@endif
	</section>
</div>