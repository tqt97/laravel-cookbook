@props(['items' => null])

@php
    $isArrayMode = is_array($items) && !empty($items);
@endphp

<nav class="flex" aria-label="Breadcrumb">
    <ol class="flex items-center flex-wrap text-sm text-gray-800">
        @if ($isArrayMode)
            @foreach ($items as $item)
                <x-breadcrumb-item :label="$item['label']" :href="$item['href'] ?? null" :icon="$item['icon'] ?? null"
                    :first="$loop->first" :active="$loop->last" />
            @endforeach
        @else
            {{ $slot }}
        @endif
    </ol>
</nav>
