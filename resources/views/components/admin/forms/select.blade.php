@props([
    'name',
    'label' => null,
    'options' => [],
    'optionValue' => 'id',
    'optionLabel' => 'name',
    'selected' => null,
    'required' => false,
    'placeholder' => null,
])

@if($label)
    <x-admin.forms.label :name="$name" :label="$label" :required="$required" />
@endif
<select
    name="{{ $name }}"
    id="{{ $name }}"
    {{ $attributes->merge(['class' => 'custom-input']) }}
    @required($required)
>
    @if($placeholder)
        <option value="">{{ __($placeholder) }}</option>
    @endif
    @foreach($options as $option)
        <option value="{{ $option[$optionValue] }}"
            {{ (string) $selected === (string) $option[$optionValue] ? 'selected' : '' }}>
            {{ $option[$optionLabel] }}
        </option>
    @endforeach
</select>
