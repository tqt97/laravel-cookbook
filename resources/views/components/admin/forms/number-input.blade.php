@props([
    'name',
    'label' => null,
    'value' => 0,
    'required' => false,
    'placeholder' => null,
    'disabled' => false
])

@if($label)
    <x-admin.forms.label :name="$name" :label="$label" :required="$required" />
@endif

<input @disabled($disabled) {{ $attributes->merge(['class' => 'custom-input']) }} id="{{ $name }}" class="mt-1 w-full" type="number" name="{{ $name }}" value="{{ old($name, $value) }}" placeholder="{{ $placeholder }}" @required($required)>
