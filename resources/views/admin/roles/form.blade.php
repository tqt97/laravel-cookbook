@php
    $isEdit = $role->exists;
    $action = $isEdit ? route('admin.roles.update', $role) : route('admin.roles.store');
    $method = $isEdit ? 'PUT' : 'role';
    $labelText = $isEdit ? 'common.edit' : 'common.create';
    $title = $isEdit ? 'role.pages.edit' : 'role.pages.create';
    $submitText = $isEdit ? 'common.update' : 'common.save';
@endphp

<x-admin.pages.form>
    <x-slot name="breadcrumb">
        <x-breadcrumb :items="[
        ['label' => 'role.title', 'href' => route('admin.roles.index')],
        ['label' => $labelText],
    ]" />
    </x-slot>

    <x-slot name="headerPage">
        <x-admin.commons.header-action :title="$title" :isBack="true" routeBack="admin.roles.index" />
    </x-slot>

    <x-slot name="form">
        <form method="POST" action="{{ $action }}">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif
            <div class="mb-4">
                <x-admin.forms.text-input name="name" label="{{ __('role.form.name') }}" :value="$role->name"
                    :required="true" />
            </div>
            <div class="my-4 w-full1">
                <div class="flex items-center justify-between">
                    <h3 class="text-md font-semibold mb-2">Permissions</h3>
                    <div class="mb-4 border1 rounded-lg bg-gray-501/10 flex items-center gap-2">
                        <label for="check-all" class="cursor-pointer">{{ __('role.form.check_all') }}</label>
                        <input type="checkbox" id="check-all"
                            class="custom-checkbox accent-gray-800 focus:outline-none focus:ring-0 focus:shadow-outline rounded cursor-pointer">
                    </div>
                </div>
                <x-input-error :messages="$errors->get('permissions')" class="my-2" />

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($groupedPermissions as $group => $permissions)
                        <x-admin.commons.permission-group :group="$group" :permissions="$permissions"
                            :selected="$rolePermissions" />
                    @endforeach
                </div>
            </div>

            <div class="mt-2">
                <x-primary-button type="submit">{{ __($submitText) }}</x-primary-button>
            </div>
        </form>
    </x-slot>

    @once
        @push('js')
           @vite('resources/js/admin/roles/form.js')
        @endpush
    @endonce
</x-admin.pages.form>
