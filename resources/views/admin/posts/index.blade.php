<x-admin.pages.list>
    <x-slot name="breadcrumb">
        <x-breadcrumb :items="[['label' => 'post.title']]" />
    </x-slot>

    <x-slot name="headerPage">
        <x-admin.commons.header-action title="post.pages.list" route="admin.posts.create" />
    </x-slot>

    <x-slot name="headerAction">
        <x-admin.commons.header-filter routeIndex="admin.posts.index" routeDelete="admin.posts.bulk-delete"
            :isFilter="true" />
    </x-slot>

    <x-slot name="thead">
        <th class="th sticky left-0 bg-gray-800 z-10">
            <input type="checkbox" name="check-all" id="check-all" class="rounded-md w-5 h-5 cursor-pointer">
        </th>
        <th class="th sticky left-12 bg-gray-800 z-10">{{ __('post.columns.title') }}
        </th>
        <th class="th">{{ __('post.columns.category_id') }}</th>
        <th class="th-center">{{ __('post.columns.view_count') }}</th>
        <th class="th-center">{{ __('post.columns.tags') }}</th>
        <th class="th-center">{{ __('post.columns.comments_count') }}</th>
        <th class="th-center">{{ __('post.columns.is_featured') }}</th>
        <th class="th-center">{{ __('post.columns.status') }}</th>
        <th class="th-center"></th>
    </x-slot>

    <x-slot name="tbody">
        @forelse($posts as $post)
            <tr class="hover:bg-gray-50/50 relative">
                <td class="td sticky left-0 z-10">
                    <input type="checkbox" name="ids[]" id="{{ $post->id }}" value="{{ $post->id }}"
                        class="checkbox-item rounded-md w-5 h-5 cursor-pointer">
                </td>
                <td class="td sticky left-12 bg-white z-10">
                    <span class="max-w-[450px] truncate block" title="{{ $post->title }}">{{ $post->title }}</span>
                </td>
                <td class="td">{{ $post->category->name }}</td>
                <td class="td-center">{{ $post->view_count }}</td>
                <td class="td-center">{{ $post->tags_count }}</td>
                <td class="td-center">{{ $post->comments_count }}</td>
                <td class="td-center">
                    <x-admin.commons.badge :type="$post->is_featured ? 'success' : 'danger'">
                        {{ $post->is_featured ? 'Yes' : 'No' }}
                    </x-admin.commons.badge>
                </td>
                <td class="td-center">
                    @if ($post->trashed())
                        <x-admin.commons.badge type="danger">{{ __('common.trashed') }}</x-admin.commons.badge>
                    @else
                        <div class="flex flex-col items-center gap-1">
                            @if ($post->is_published)
                                <x-admin.commons.badge type="success">{{ __('common.published') }}</x-admin.commons.badge>
                                <x-admin.commons.badge
                                    type="info">{{ $post->published_at->diffForHumans() }}</x-admin.commons.badge>
                            @else
                                <x-admin.commons.badge>{{ __('common.unpublished') }}</x-admin.commons.badge>
                            @endif
                        </div>
                    @endif
                </td>
                <x-admin.commons.tables.td-action>
                    @if($post->trashed())
                        <x-admin.commons.action-button method="PATCH" :action="route('admin.posts.restore', $post)">
                            <x-icons.arrow-uturn-left />
                        </x-admin.commons.action-button>

                        <x-admin.commons.action-button method="DELETE" :action="route('admin.posts.force-delete', $post)">
                            <x-icons.archive-box-x-mark />
                        </x-admin.commons.action-button>
                    @else
                        <a href="{{ route('admin.posts.duplicate', $post) }}" class="text-cyan-600 hover:text-cyan-800">
                            <x-icons.duplicate />
                        </a>
                        <a href="{{ route('admin.posts.edit', $post) }}" class="text-blue-600 hover:text-blue-800">
                            <x-icons.pencil-square />
                        </a>
                        <x-admin.commons.action-button method="DELETE" :action="route('admin.posts.destroy', $post)">
                            <x-icons.trash class="text-red-600 hover:text-red-800" />
                        </x-admin.commons.action-button>
                    @endif
                </x-admin.commons.tables.td-action>
            </tr>
        @empty
            <x-admin.commons.tables.no-data :columns="9" />
        @endforelse
    </x-slot>

    <x-slot name="pagination">
        <x-admin.commons.tables.pagination :items="$posts" />
    </x-slot>
</x-admin.pages.list>
