<x-admin.pages.list>
    <x-slot name="breadcrumb">
        <x-breadcrumb :items="[['label' => 'role.title']]" />
    </x-slot>

    <x-slot name="headerPage">
        <x-admin.commons.header-action title="role.pages.list" route="admin.roles.create" />
    </x-slot>

    <x-slot name="headerAction">
        <x-admin.commons.header-filter routeIndex="admin.roles.index" routeDelete="admin.roles.bulk-delete" />
    </x-slot>

    <x-slot name="thead">
        <th class="th sticky left-0 bg-gray-800 z-10">
            <input type="checkbox" name="check-all" id="check-all" class="rounded-md w-5 h-5 cursor-pointer">
        </th>
        <th class="th">{{ __('role.columns.name') }}</th>
        <th class="th-center">{{ __('role.columns.permissions') }}</th>
        <th class="th-center"></th>
    </x-slot>
    <x-slot name="tbody">
        @forelse($roles as $role)
            <tr class="hover:bg-gray-50/50 relative">
                <td class="td sticky left-0 z-10">
                    <input type="checkbox" name="ids[]" id="{{ $role->id }}" value="{{ $role->id }}"
                        class="checkbox-item rounded-md w-5 h-5 cursor-pointer">
                </td>
                <td class="td">{{ $role->name }}</td>
                <td class="td-center">{{ $role->permissions_count }}</td>
                <x-admin.commons.tables.td-action>
                    <a href="{{ route('admin.roles.edit', $role) }}" class="text-blue-600 hover:text-blue-800">
                        <x-icons.pencil-square />
                    </a>
                    <x-admin.commons.action-button method="DELETE" :action="route('admin.roles.destroy', $role)">
                        <x-icons.trash class="text-red-600 hover:text-red-800" />
                    </x-admin.commons.action-button>
                </x-admin.commons.tables.td-action>
            </tr>
        @empty
            <x-admin.commons.tables.no-data :columns="4" />
        @endforelse
    </x-slot>

    <x-slot name="pagination">
        <x-admin.commons.tables.pagination :items="$roles" />
    </x-slot>
</x-admin.pages.list>
