<x-admin.pages.list>
    <x-slot name="breadcrumb">
        <x-breadcrumb :items="[['label' => 'permission.title']]" />
    </x-slot>

    <x-slot name="headerPage">
        <x-admin.commons.header-action title="permission.pages.list" route="admin.permissions.create" />
    </x-slot>

    <x-slot name="headerAction">
        <x-admin.commons.header-filter routeIndex="admin.permissions.index"
            routeDelete="admin.permissions.bulk-delete" />
    </x-slot>

    <x-slot name="thead">
        <th class="th sticky left-0 bg-gray-800 z-10">
            <input type="checkbox" name="check-all" id="check-all" class="rounded-md w-5 h-5 cursor-pointer">
        </th>
        <th class="th">{{ __('permission.columns.name') }}</th>
        <th class="th-center">{{ __('permission.columns.role') }}</th>
        <th class="th-center"></th>
    </x-slot>

    <x-slot name="tbody">
        @forelse($permissions as $permission)
            <tr class="hover:bg-gray-50/50 relative">
                <td class="td sticky left-0 z-10">
                    <input type="checkbox" name="ids[]" id="{{ $permission->id }}" value="{{ $permission->id }}"
                        class="checkbox-item rounded-md w-5 h-5 cursor-pointer">
                </td>
                <td class="td">{{ $permission->name }}</td>
                <td class="td-center">{{ $permission->roles_count }}</td>
                <x-admin.commons.tables.td-action>
                    <a href="{{ route('admin.permissions.edit', $permission) }}" class="text-blue-600 hover:text-blue-800">
                        <x-icons.pencil-square />
                    </a>
                    <x-admin.commons.action-button method="DELETE" :action="route('admin.permissions.destroy', $permission)">
                        <x-icons.trash class="text-red-600 hover:text-red-800" />
                    </x-admin.commons.action-button>
                </x-admin.commons.tables.td-action>
            </tr>
        @empty
            <x-admin.commons.tables.no-data :columns="4" />
        @endforelse
    </x-slot>

    <x-slot name="pagination">
        <x-admin.commons.tables.pagination :items="$permissions" />
    </x-slot>
</x-admin.pages.list>
