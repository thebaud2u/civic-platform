<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-end gap-2 rounded-md bg-success-700 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-success-700 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed']) }}>
	{{ $slot }}
</button>
