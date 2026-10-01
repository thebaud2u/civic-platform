<button
	x-on:click="$dispatch('close')"
	{{ $attributes->merge([
		'type' => 'button',
		'class' => 'inline-flex items-center gap-2 rounded-md bg-danger-700 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-danger-600 active:bg-danger-800 focus:outline-none focus:ring-2 focus:ring-danger-700 focus:ring-offset-2'
	]) }}
>
	{{ $title ?? 'Annuler' }}
</button>