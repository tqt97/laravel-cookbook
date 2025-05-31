@php
    $isEdit = $role->exists;
    $action = $isEdit ? route('admin.roles.update', $role) : route('admin.roles.store');
    $method = $isEdit ? 'PUT' : 'POST';
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $isEdit ? __('common.edit') : __('common.create') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold mb-4">{{ __('role.pages.create') }}</h2>
                        <a href="{{ route('admin.roles.index') }}"
                            class="px-4 py-[10px] text-sm bg-gray-800 hover:bg-gray-900 text-white rounded-md dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                            ← {{ __('common.back') }}
                        </a>
                    </div>

                    <div class="bg-white border rounded-lg px-8 py-6 mx-auto my-8">
                        <form method="POST" action="{{ $action }}">
                            @if($isEdit)
                                @method('PUT')
                            @endif
                            @csrf
                            <div class="flex gap-4 items-center">
                                <div class="mb-4 w-full">
                                    <x-forms.label name="name" :label="__('role.form.name')" required />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                        value="{{  old('name', $role->name) }}" required />
                                </div>
                            </div>
                            {{-- <div class="flex gap-4 items-center"> --}}
                                {{-- <div class="mb-4 w-1/21"> --}}
                                    <div class="my-4 w-full1">
                                        <h3 class="text-md font-bold mb-4">Permissions</h3>
                                        <div class="mb-4 border p-3 rounded-lg bg-gray-50">
                                            <label
                                                class="font-semibold text-base flex items-center gap-2 cursor-pointer">
                                                <input type="checkbox" id="check-all"
                                                    class="custom-checkbox accent-gray-800 focus:outline-none focus:ring-0 focus:shadow-outline rounded cursor-pointer">
                                                <span>{{ __('role.form.check_all') }}</span>
                                            </label>
                                        </div>
                                        <x-input-error :messages="$errors->get('permissions')" class="my-2" />

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            @foreach($groupedPermissions as $group => $permissions)
                                                <x-roles.permission-group :group="$group" :permissions="$permissions"
                                                    :selected="$rolePermissions" />
                                            @endforeach
                                        </div>
                                    </div>
                                    {{--
                                </div> --}}
                                {{-- </div> --}}
                            <div>
                                <x-primary-button type="submit">{{ __('common.save') }}</x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @once
        @push('js')
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const updateParentCheckbox = (group) => {
                        const children = document.querySelectorAll(`.group-${group}`);
                        const parent = document.querySelector(`.group-checkbox[data-group="${group}"]`);
                        const allChecked = [...children].every(chk => chk.checked);
                        const someChecked = [...children].some(chk => chk.checked);

                        parent.checked = allChecked;
                        parent.indeterminate = !allChecked && someChecked;
                    };

                    // Handle parent to children
                    document.querySelectorAll('.group-checkbox').forEach(parent => {
                        const group = parent.dataset.group;

                        parent.addEventListener('change', () => {
                            const children = document.querySelectorAll(`.group-${group}`);
                            children.forEach(child => {
                                child.checked = parent.checked;
                            });
                        });
                    });

                    // Handle children to parent (2 chiều)
                    document.querySelectorAll('.child-checkbox').forEach(child => {
                        const classes = [...child.classList];
                        const group = classes.find(c => c.startsWith('group-'))?.replace('group-', '');

                        child.addEventListener('change', () => {
                            updateParentCheckbox(group);
                        });

                        // Cập nhật ban đầu
                        if (group) updateParentCheckbox(group);
                    });

                    // Check All box
                    const checkAllBox = document.getElementById('check-all');

                    checkAllBox.addEventListener('change', () => {
                        const allCheckboxes = document.querySelectorAll('.child-checkbox, .group-checkbox');
                        // allCheckboxes.forEach(chk => chk.checked = checkAllBox.checked);
                        allCheckboxes.forEach(chk => {
                            chk.checked = checkAllBox.checked;
                            chk.indeterminate = false; // reset indeterminate luôn
                        });
                    });

                    const updateCheckAllState = () => {
                        const allChildren = document.querySelectorAll('.child-checkbox');
                        const allChecked = [...allChildren].every(c => c.checked);
                        const someChecked = [...allChildren].some(c => c.checked);

                        checkAllBox.checked = allChecked;
                        checkAllBox.indeterminate = !allChecked && someChecked;
                    };

                    updateCheckAllState(); // init state
                });
            </script>
        @endpush
    @endonce

</x-app-layout>
