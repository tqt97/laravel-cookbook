@php
    $isEdit = $permission->exists;
    $action = $isEdit ? route('admin.permissions.update', $permission) : route('admin.permissions.store');
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
                        <h2 class="text-xl font-bold mb-4">{{ __('permission.pages.create') }}</h2>
                        <a href="{{ route('admin.permissions.index') }}"
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
                                    <x-forms.label name="name" :label="__('permission.form.name')" required />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                        value="{{  old('name', $permission->name) }}" required />
                                </div>
                            </div>
                            <div>
                                <x-primary-button type="submit">{{ __('common.save') }}</x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
