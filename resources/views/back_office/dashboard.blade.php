@extends('back_office.layouts.app')

@section('body')
	<h1 class="text-gray-700 text-3xl font-medium">
		Tableau de bord
	</h1>

	<div class="mt-4">
		<div class="flex flex-wrap gap-y-4">
			<div class="px-6 sm:w-1/2 xl:w-1/3 xl:mt-0">
				<div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white">
					<button type="button" class="text-gray-900 bg-gradient-to-r from-teal-200 to-lime-200 hover:bg-gradient-to-l hover:from-teal-200 hover:to-lime-200 focus:ring-4 focus:outline-none focus:ring-lime-200 dark:focus:ring-teal-700 font-medium rounded-lg text-sm px-3 py-2.5 text-center mr-2 mb-2">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"class="size-6">
							<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
						</svg>
					</button>

					<div class="mx-5">
						<h4 class="text-2xl font-semibold text-gray-700">
							{{ $countUsers }}
						</h4>

						<div class="text-gray-500">
							Utilisateurs
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="mt-8">
		<h1 class="text-gray-700 text-3xl font-medium">
			Utilisateurs
		</h1>

		<div class="container mt-4">
			<livewire:backoffice.users.users />
		</div>
	</div>
@endsection
