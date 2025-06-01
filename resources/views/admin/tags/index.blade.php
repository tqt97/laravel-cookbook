<x-admin.pages.list>
    <x-slot name="breadcrumb">
        <x-breadcrumb :items="[['label' => 'tag.title']]" />
    </x-slot>

    <x-slot name="headerPage">
        <x-admin.commons.header-action title="tag.pages.list" route="admin.tags.create" />
    </x-slot>

    <x-slot name="headerAction">
        <x-admin.commons.header-filter routeIndex="admin.tags.index" routeDelete="admin.tags.bulk-delete" />
    </x-slot>

    <x-slot name="thead">
        <x-admin.commons.tables.th sticky>
            <input type="checkbox" name="check-all" id="check-all" class="rounded-md w-5 h-5 cursor-pointer">
        </x-admin.commons.tables.th>
        <x-admin.commons.tables.th>{{ __('tag.columns.name') }}</x-admin.commons.tables.th>
        <x-admin.commons.tables.th center>{{ __('tag.columns.posts') }}</x-admin.commons.tables.th>
        <x-admin.commons.tables.th center></x-admin.commons.tables.th>
    </x-slot>

    <x-slot name="tbody">
        @forelse($tags as $tag)
            <tr class="hover:bg-gray-50/50 relative">
                <x-admin.commons.tables.td sticky>
                    <input type="checkbox" name="ids[]" id="{{ $tag->id }}" value="{{ $tag->id }}"
                        class="checkbox-item rounded-md w-5 h-5 cursor-pointer">
                </x-admin.commons.tables.td>
                <x-admin.commons.tables.td>{{ $tag->name }}</x-admin.commons.tables.td>
                <x-admin.commons.tables.td center>{{ $tag->posts_count }}</x-admin.commons.tables.td>
                <x-admin.commons.tables.td-action>
                    <a href="{{ route('admin.tags.duplicate', $tag) }}" class="text-cyan-600 hover:text-cyan-800">
                        <x-icons.duplicate />
                    </a>
                    <a href="{{ route('admin.tags.edit', $tag) }}" class="text-blue-600 hover:text-blue-800">
                        <x-icons.pencil-square />
                    </a>
                    <x-admin.commons.action-button method="DELETE" :action="route('admin.tags.destroy', $tag)">
                        <x-icons.trash class="text-red-600 hover:text-red-800" />
                    </x-admin.commons.action-button>
                </x-admin.commons.tables.td-action>
            </tr>
        @empty
            <x-admin.commons.tables.no-data :columns="4" />
        @endforelse
    </x-slot>

    <x-slot name="pagination">
        <x-admin.commons.tables.pagination :items="$tags" />
    </x-slot>
</x-admin.pages.list>
