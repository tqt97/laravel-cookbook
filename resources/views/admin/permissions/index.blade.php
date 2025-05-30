<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('common.list') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- Header --}}
                    <div class="flex items-center justify-between">
                        <h2 class="font-bold text-xl">{{ __('permission.pages.list') }}</h2>
                        <a href="{{ route('admin.permissions.create') }}">
                            <x-primary-button>
                                <x-icons.plus class="mr-2 text-white" /> {{ __('common.create') }}
                            </x-primary-button>
                        </a>
                    </div>
                    <div class="flex mt-5 items-center justify-between">
                        {{-- Bulk delete --}}
                        <div class="flex items-center gap-1">
                            {{-- <form id="bulk-delete-form" method="POST" action="{{ route('admin.permissions.bulk-delete') }}">
                                @csrf
                                @method('DELETE')
                                <div id="bulk-delete-inputs"></div>
                                <x-primary-button type="submit" aria-label="{{ __('Bulk delete') }}"
                                    id="bulk-delete-button" style="display: none;" class="text-white rounded-md transition
                                bg-red-500 hover:bg-red-600
                                disabled:opacity-0 disabled:cursor-not-allowed"
                                    onclick="return confirm('{{ __('Bulk delete') }}')">
                                    {{ __('common.bulk_delete') }}
                                </x-primary-button>
                            </form> --}}
                            <div id="selected-count" class="text-gray-700" style="display: none;">
                                {{ __('common.select') }}
                                <strong id="selected-count-number"></strong>
                                {{ __('common.items') }}
                            </div>
                        </div>
                        {{-- Search --}}
                        <div class="flex items-center gap-1">
                            <form action="{{ route('admin.permissions.index') }}" method="GET" class="flex items-center gap-1">
                                <input type="search" id="search" class="w-full rounded-md py-[8px]" name="search"
                                    value="{{ request('search') }}" placeholder="{{ __('common.search_placeholder') }}"
                                    required autocomplete="search" />
                                <x-primary-button type="submit">
                                    <x-icons.search class="mr-1 text-white" /> {{ __('common.search') }}
                                </x-primary-button>
                            </form>
                            <a href="{{ route('admin.permissions.index') }}" id="clear-filters-button" class="hidden">
                                <x-primary-button>
                                    <x-icons.x-mark class="mr-1 text-white" />{{ __('common.reset') }}
                                </x-primary-button>
                            </a>
                        </div>
                    </div>

                    <div class="shadow-md rounded-md overflow-hidden mt-5">
                        <table class="w-full table-striped">
                            <thead>
                                <tr class="bg-gray-800 text-white text-left">
                                    <th class="px-4 py-4 text-left">
                                        <input type="checkbox" name="check-all" id="check-all"
                                            class="rounded-md w-5 h-5 cursor-pointer">
                                    </th>
                                    <th class="px-4 py-4">{{ __('permission.columns.name') }}</th>
                                    <th class="px-4 py-4">{{ __('permission.columns.role') }}</th>
                                    <th class="px-4 py-4 text-center"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($permissions as $permission)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3">
                                            <input type="checkbox" name="ids[]" id="{{ $permission->id }}" value="{{ $permission->id }}"
                                                class="checkbox-item rounded-md w-5 h-5 cursor-pointer">
                                        </td>
                                        <td class="px-4 py-3">{{ $permission->name }}</td>
                                        <td class="px-4 py-3">{{ $permission->roles_count }}</td>
                                        <td class="flex items-center justify-center gap-2">
                                            {{-- <a href="{{ route('admin.permissions.duplicate', $permission) }}"
                                                class="text-cyan-600 hover:text-cyan-800">
                                                <x-icons.duplicate />
                                            </a> --}}
                                            <a href="{{ route('admin.permissions.edit', $permission) }}"
                                                class="text-blue-600 hover:text-blue-800">
                                                <x-icons.pencil-square />
                                            </a>
                                            <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST"
                                                onsubmit="return confirm('{{ __('common.confirm_delete') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="py-3" aria-label="{{ __('common.delete') }}">
                                                    <x-icons.trash class="text-red-500 hover:text-red-700" />
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-3">
                                            {{ __('common.no_data') }}
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                        <div class="px-3 py-4">
                            {{ $permissions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
