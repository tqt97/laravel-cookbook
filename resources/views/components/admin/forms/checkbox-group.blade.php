@props([
    'name',
    'label' => '',
    'checked' => false,
])

<x-admin.forms.label :name="$name" :label="$label" />
<x-admin.forms.checkbox :name="$name" :checked="$checked" id="{{ $name }}" />
