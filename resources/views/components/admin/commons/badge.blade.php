@props(['type' => 'default'])

@php
    $colors = [
        'success' => 'bg-green-500',
        'danger' => 'bg-red-500',
        'warning' => 'bg-orange-500',
        'info' => 'bg-blue-500',
        'default' => 'bg-gray-500',
    ];
@endphp

<span class="{{ $colors[$type] ?? $colors['default'] }} text-white py-1 px-2 rounded-full text-xs">
    {{ $slot }}
</span>
