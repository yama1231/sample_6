<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-sm btn-outline-primary']) }}>
    {{ $slot }}
</button>
