@props([
    'name',
    'label' => null,
    'options' => [],
    'optionValue' => 'id',
    'optionLabel' => 'name',
    'selected' => [],
    'placeholder' => null,
])

<div>
    @if($label)
        <x-admin.forms.label :name="$name" :label="$label" />
    @endif
    <select
        name="{{ $name }}[]"
        id="{{ $name }}"
        multiple
        {{ $attributes->merge(['class' => 'custom-input']) }}
    >
        @if($placeholder)
            <option value="__none__">{{ __($placeholder) }}</option>
        @endif
        @foreach($options as $option)
            <option value="{{ $option[$optionValue] }}"
                {{ in_array($option[$optionValue], old($name, $selected)) ? 'selected' : '' }}>
                {{ $option[$optionLabel] }}
            </option>
        @endforeach
    </select>
</div>
