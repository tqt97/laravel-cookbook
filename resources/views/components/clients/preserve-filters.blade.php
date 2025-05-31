@props(['except' => []])

@php
    $preservedKeys = ['search', 'category', 'tag', 'limit', 'sort', 'direction'];
@endphp

@foreach ($preservedKeys as $key)
    @if (!in_array($key, $except) && request($key))
        <input type="hidden" name="{{ $key }}" value="{{ request($key) }}">
    @endif
@endforeach
