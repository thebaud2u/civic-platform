<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-end gap-2 rounded-md bg-primary-700 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-primary-700 focus:ring-offset-2']) }}>
	{{ $slot }}
</button>
