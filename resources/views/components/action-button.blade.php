<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-end gap-2 rounded-md p-2 text-sm font-medium shadow-sm transition hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2']) }}>
	{{ $slot }}
</button>
