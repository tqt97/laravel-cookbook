@props([
    'name',
    'label' => null,
    'value' => '',
    'required' => false,
    'rows' => 5,
])

<div>
    @if($label)
        <x-admin.forms.label :name="$name" :label="$label" :required="$required" />
    @endif
    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        {{ $attributes->merge(['class' => 'custom-input']) }}
        @if($required) required @endif
    >{{ old($name, $value) }}</textarea>
</div>
