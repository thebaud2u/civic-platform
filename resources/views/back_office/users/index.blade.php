<x-backoffice-layout>
	<div x-data="{ tab: 'users-tab' }">
		<div class="mb-4 border-b border-gray-200">
			<ul class="flex flex-wrap -mb-px text-sm font-medium">
				<li class="mr-2">
					<button
						@click="tab = 'users-tab'"
						type="button"
						class="inline-block rounded-t-lg border-b-2 p-4"
						:class="tab === 'users-tab'
							? 'border-gray-900 text-gray-900'
							: 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-600'"
					>
						Utilisateurs
					</button>
				</li>
			</ul>
		</div>

		<div x-show="tab === 'users-tab'" class="rounded-lg bg-white p-6">
			<livewire:backoffice.users />
		</div>
	</div>
</x-backoffice-layout>