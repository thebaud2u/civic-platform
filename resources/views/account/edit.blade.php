<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			Mon compte
		</h2>
	</x-slot>

	<div class="mx-auto flex flex-col w-full max-w-7xl items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
			<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
				<div class="max-w-xl">
					@include('account.partials.view-account-information')
				</div>
			</div>

			<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
				<div class="max-w-xl">
					@include('account.partials.update-password-form')
				</div>
			</div>
		</div>
	</div>
</x-app-layout>
