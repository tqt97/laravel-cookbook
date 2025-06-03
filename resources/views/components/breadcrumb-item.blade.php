@props(['label', 'href' => null, 'active' => false, 'icon' => null, 'first' => false])

<li class="flex items-center">
    @unless($first)
        <svg class="w-4 h-4 mx-1 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
    @endunless

    <div class="inline-flex items-start space-x-1">
        @if ($icon)
            <x-dynamic-component :component="'icons.' . $icon" class="w-4 h-4 text-gray-500" />
        @endif

        @if ($active)
            <span class="text-gray-800 font-semibold">
                {{ __($label) !== $label ? __($label) : $label }}
            </span>
        @else
            <a href="{{ $href }}" class="hover:underline text-gray-800">
                {{ __($label) !== $label ? __($label) : $label }}
            </a>
        @endif
    </div>
</li>
