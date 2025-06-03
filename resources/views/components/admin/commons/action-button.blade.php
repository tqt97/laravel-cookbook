@props([
    'method' => 'POST',
    'action',
    'confirm' => true,
])
@php
    $confirmMessage = match (true) {
        is_string($confirm) => __('common.' . $confirm),
        $confirm === true => __('common.confirm_default'),
        default => null,
    };
@endphp

<form action="{{ $action }}" method="POST"
    @if($confirmMessage) onsubmit="return confirm('{{ $confirmMessage }}')" @endif
>
    @csrf
    @method($method)
    <button type="submit" class="py-3">
        {{ $slot }}
    </button>
</form>
