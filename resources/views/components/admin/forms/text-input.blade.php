@props([
    'name',
    'type' => 'text',
    'label' => null,
    'value' => '',
    'required' => false,
    'placeholder' => null,
    'disabled' => false
])

@if($label)
    <x-admin.forms.label :name="$name" :label="$label" :required="$required" />
@endif

<input @disabled($disabled) {{ $attributes->merge(['class' => 'custom-input']) }} id="{{ $name }}" class="mt-1 w-full" type="{{ $type }}" name="{{ $name }}" value="{{ old($name, $value) }}" placeholder="{{ $placeholder }}" @required($required)>
