@php
    $isEdit = $tag->exists;
    $action = $isEdit ? route('admin.tags.update', $tag) : route('admin.tags.store');
    $method = $isEdit ? 'PUT' : 'tag';
    $labelText = $isEdit ? 'common.edit' : 'common.create';
    $title = $isEdit ? 'tag.pages.edit' : 'tag.pages.create';
    $submitText = $isEdit ? 'common.update' : 'common.save';
@endphp

<x-admin.pages.form>
    <x-slot name="breadcrumb">
        <x-breadcrumb :items="[
        ['label' => 'tag.title', 'href' => route('admin.tags.index')],
        ['label' => $labelText],
    ]" />
    </x-slot>

    <x-slot name="headerPage">
        <x-admin.commons.header-action :title="$title" :isBack="true" routeBack="admin.tags.index" />
    </x-slot>

    <x-slot name="form">
        <form method="POST" action="{{ $action }}">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif
            <div class="mb-4">
                <x-admin.forms.text-input name="name" label="{{ __('tag.form.name') }}" :value="$tag->name"
                    :required="true" />
            </div>

            <div class="mt-2">
                <x-primary-button type="submit">{{ __($submitText) }}</x-primary-button>
            </div>
        </form>
    </x-slot>

    {{-- @push('js')
        @vite('resources/js/admin/tags/edit.js')
    @endpush --}}
</x-admin.pages.form>
