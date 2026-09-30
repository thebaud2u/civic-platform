<x-backoffice-layout>
	<div x-data="{ tab: 'tab' }">
		<div class="mb-4 border-b border-gray-200">
			<ul class="flex flex-wrap -mb-px text-sm font-medium">
				<li class="mr-2">
					<button
						@click="tab = 'tab'"
						type="button"
						class="inline-block rounded-t-lg border-b-2 p-4"
						:class="tab === 'tab'
							? 'border-gray-900 text-gray-900'
							: 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-600'"
					>
						x
					</button>
				</li>
			</ul>
		</div>

		<div x-show="tab === 'tab'" class="rounded-lg bg-white p-6">

		</div>
	</div>
</x-backoffice-layout>