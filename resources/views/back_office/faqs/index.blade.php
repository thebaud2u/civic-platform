<x-backoffice-layout>
	<h1 class="text-gray-700 text-3xl font-medium mb-4">
		FAQs
	</h1>

	<div class="container mt-4">
		<div x-data="{ tab: 'faqs-tab' }">
			<div class="mb-4 border-b border-gray-200 dark:border-gray-700">
				<ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="faqsTab" data-tabs-toggle="#faqsTabContent" role="tablist">
					<li class="mr-2" role="presentation">
						<button @click.prevent="tab = 'faqs-tab'" id="faqs-tab" data-tabs-target="#faqs" type="button" role="tab" aria-controls="faqs" class="inline-block p-4 border-b-2 rounded-t-lg" :class="{ 'text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500': tab == 'tab1'}">
							FAQs
						</button>
					</li>

					<li class="mr-2" role="presentation">
						<button @click.prevent="tab = 'faq-rubriques'" id="faq-rubriques-tab" data-tabs-target="#faq-rubriques" type="button" role="tab" aria-controls="faq-rubriques" class="inline-block p-4 border-b-2 rounded-t-lg" :class="{ 'text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500': tab == 'tab2'}">
							Rubriques
						</button>
					</li>

					<li class="mr-2" role="presentation">
						<button @click.prevent="tab = 'faq-questions-tab'" id="faq-questions-tab" data-tabs-target="#faq-questions" type="button" role="tab" aria-controls="faq-questions" class="inline-block p-4 border-b-2 rounded-t-lg" :class="{ 'text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500': tab == 'tab2'}">
							Questions
						</button>
					</li>
				</ul>
			</div>

			<div id="faqsTabContent">
				<div x-show="tab == 'faqs-tab'" class="p-4 rounded-lg bg-white dark:bg-gray-800" id="faqs" role="tabpanel" aria-labelledby="faqs-tab">
					<livewire:backoffice.faqs.faqs />
				</div>

				<div x-show="tab == 'faq-rubriques-tab'" class="p-4 rounded-lg bg-white dark:bg-gray-800" id="faq-rubriques" role="tabpanel" aria-labelledby="faq-rubriques-tab">
					<livewire:backoffice.faqs.faq-rubriques />
				</div>

				<div x-show="tab == 'faq-questions-tab'" class="p-4 rounded-lg bg-white dark:bg-gray-800" id="faq-questions" role="tabpanel" aria-labelledby="faq-questions-tab">
					<livewire:backoffice.faqs.faq-questions />
				</div>
			</div>
		</div>
	</div>
</x-backoffice-layout>