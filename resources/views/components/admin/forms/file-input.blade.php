@props([
    'name',
    'label' => null,
    'accept' => null,
])

@if($label)
    <x-admin.forms.label :name="$name" :label="$label" />
@endif
<x-text-input type="file" name="{{ $name }}" id="{{ $name }}" accept="{{ $accept ?? 'image/*' }}" class="w-full mt-1"/>

