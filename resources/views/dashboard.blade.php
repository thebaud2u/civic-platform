<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			Tableau de bord
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
				<div class="p-6 text-gray-900">
					<header class="mb-8">
						<h2 class="text-xl font-semibold text-gray-800">
							Mes temps
						</h2>

						<p class="mt-1 text-sm text-gray-600">
							Suivi de votre temps de travail pour la semaine en cours.
						</p>
					</header>

					{{-- Résumé de la semaine --}}
					<section aria-labelledby="week-summary-title" class="mb-8">
						<h3 id="week-summary-title" class="sr-only">
							Résumé de la semaine
						</h3>

						<div class="grid gap-4 sm:grid-cols-3">
							{{-- Temps réalisé --}}
							<div class="rounded-lg border border-gray-200 p-5">
								<p class="text-sm font-medium text-gray-600">
									Temps réalisé
								</p>

								<p class="mt-2 text-2xl font-semibold text-gray-900">
									{{ intdiv($weeklyTimeSummary['total'], 60) }}h{{ str_pad($weeklyTimeSummary['total'] % 60, 2, '0', STR_PAD_LEFT) }}
								</p>
							</div>

							@if($weeklyTimeSummary['is_hourly'])
								{{-- Temps attendu --}}
								<div class="rounded-lg border border-gray-200 p-5">
									<p class="text-sm font-medium text-gray-600">
										Temps attendu
									</p>

									<p class="mt-2 text-2xl font-semibold text-gray-900">
										{{ $user->workSchedule->weekly_hours }}h
									</p>
								</div>

								{{-- Écart --}}
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
								{{-- Forfait --}}
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

					{{-- Détail de la semaine --}}
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
												{{-- Jour --}}
												<th
													scope="row"
													class="px-4 py-4 font-medium text-gray-900 whitespace-nowrap align-top"
												>
													{{ $day['date']->translatedFormat('l d/m') }}
												</th>

												{{-- Périodes --}}
												<td class="px-4 py-4 align-top">
													@if(count($day['pairs']) > 0)
														<ul class="space-y-1">
															@foreach($day['pairs'] as $pair)
																<li class="whitespace-nowrap">
																	{{ $pair['in']->created_at->format('H:i') }}
																	<span aria-hidden="true">→</span>
																	{{ $pair['out']->created_at->format('H:i') }}
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

												{{-- Durée --}}
												<td class="px-4 py-4 font-medium text-gray-900 whitespace-nowrap align-top">
													{{ intdiv($day['minutes'], 60) }}h{{ str_pad($day['minutes'] % 60, 2, '0', STR_PAD_LEFT) }}
												</td>

												@if($weeklyTimeSummary['is_hourly'])
													{{-- Écart --}}
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
			</div>
		</div>
	</div>
</x-app-layout>