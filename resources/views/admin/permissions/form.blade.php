@php
    $isEdit = $permission->exists;
    $action = $isEdit ? route('admin.permissions.update', $permission) : route('admin.permissions.store');
    $method = $isEdit ? 'PUT' : 'permission';
    $labelText = $isEdit ? 'common.edit' : 'common.create';
    $title = $isEdit ? 'permission.pages.edit' : 'permission.pages.create';
    $submitText = $isEdit ? 'common.update' : 'common.save';
@endphp

<x-admin.pages.form>
    <x-slot name="breadcrumb">
        <x-breadcrumb :items="[
        ['label' => 'permission.title', 'href' => route('admin.permissions.index')],
        ['label' => $labelText],
    ]" />
    </x-slot>

    <x-slot name="headerPage">
        <x-admin.commons.header-action :title="$title" :isBack="true" routeBack="admin.permissions.index" />
    </x-slot>

    <x-slot name="form">
        <form method="POST" action="{{ $action }}">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif
            <div class="mb-4">
                <x-admin.forms.text-input name="name" label="{{ __('permission.form.name') }}"
                    :value="$permission->name" :required="true" />
            </div>

            <div class="mt-2">
                <x-primary-button type="submit">{{ __($submitText) }}</x-primary-button>
            </div>
        </form>
    </x-slot>
</x-admin.pages.form>
