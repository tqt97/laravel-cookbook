<x-admin.pages.list>
    <x-slot name="breadcrumb">
        <x-breadcrumb :items="[['label' => 'category.title']]" />
    </x-slot>

    <x-slot name="headerPage">
        <x-admin.commons.header-action title="category.pages.list" route="admin.categories.create" />
    </x-slot>

    <x-slot name="headerAction">
        <x-admin.commons.header-filter routeIndex="admin.categories.index" routeDelete="admin.categories.bulk-delete" />
    </x-slot>

    <x-slot name="thead">
        <th class="th sticky left-0 bg-gray-800 z-10">
            <input type="checkbox" name="check-all" id="check-all" class="rounded-md w-5 h-5 cursor-pointer">
        </th>
        <th class="th sticky left-12 bg-gray-800 z-10">{{ __('category.columns.name') }}
        </th>
        <th class="th">{{ __('category.columns.slug') }}</th>
        <th class="th-center">{{ __('category.columns.parent') }}</th>
        <th class="th-center">{{ __('category.columns.position') }}</th>
        <th class="th-center">{{ __('category.columns.is_active') }}</th>
        <th class="th-center"></th>
    </x-slot>
    <x-slot name="tbody">
        @forelse($categories as $category)
            <tr class="hover:bg-gray-50/50 relative">
                <td class="td sticky left-0 z-10">
                    <input type="checkbox" name="ids[]" id="{{ $category->id }}" value="{{ $category->id }}"
                        class="checkbox-item rounded-md w-5 h-5 cursor-pointer">
                </td>
                <td class="td sticky left-12 bg-white z-10">
                    <span class="max-w-[450px] truncate block" title="{{ $category->name }}">{{ $category->name }}</span>
                </td>
                <td class="td">{{ $category->slug }}</td>
                <td class="td-center">{{ $category->parent->name ?? '-' }}</td>
                <td class="td-center">{{ $category->position }}</td>
                <td class="td-center">
                    <x-admin.commons.badge :type="$category->is_active ? 'success' : 'danger'">
                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                    </x-admin.commons.badge>
                </td>
                <x-admin.commons.tables.td-action>
                    <a href="{{ route('admin.categories.duplicate', $category) }}"
                        class="text-cyan-600 hover:text-cyan-800">
                        <x-icons.duplicate />
                    </a>
                    <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-600 hover:text-blue-800">
                        <x-icons.pencil-square />
                    </a>
                    <x-admin.commons.action-button method="DELETE" :action="route('admin.categories.destroy', $category)">
                        <x-icons.trash class="text-red-600 hover:text-red-800" />
                    </x-admin.commons.action-button>
                </x-admin.commons.tables.td-action>
            </tr>
        @empty
            <x-admin.commons.tables.no-data :columns="7" />
        @endforelse
    </x-slot>

    <x-slot name="pagination">
        <x-admin.commons.tables.pagination :items="$categories" />
    </x-slot>
</x-admin.pages.list>
