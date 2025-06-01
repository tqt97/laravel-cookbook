@props(['href'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => '']) }}>
    {{ $slot }}
</a>
