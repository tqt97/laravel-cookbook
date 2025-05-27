@props(['post'])

<div
    class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 overflow-hidden border border-gray-100">
    <div class="p-6">
        <h2 class="text-xl font-semibold mb-2 line-clamp-2 min-h-[3.5rem]">
            <a href="{{ route('posts.show', $post) }}" title="{{ $post->title}}">
                {{ $post->title}}
            </a>
        </h2>

        <div class="flex items-center justify-between gap-4 text-sm text-gray-5001 mb-2">
            <div class="flex gap-1">
                <x-icons.user-circle />
                <span>{{ $post->user->name }}</span>
            </div>
            <div class="flex gap-1">
                <x-icons.calendar />
                <span>{{ $post->created_at->format('Y-m-d') }}</span>
            </div>
        </div>
        <div class="flex  justify-between text-sm my-2">
            <div class="flex gap-1">
                <x-icons.time />
                {{ Str::readingTime($post->content) }}
            </div>
            <div class="flex gap-1">
                <x-icons.book-open />
                <span>{{ $post->category->name }}</span>
            </div>
        </div>


        <div class="text-gray-600 mb-4 line-clamp-2">
            {!! $post->content !!}
        </div>
        <div class="flex justify-center gap-2">
            <button
                class='group inline-flex w-full justify-center gap-2 items-center px-4 py-[12px] hover:bg-gray-800 border rounded-md font-semibold text-sm text-gray-800 hover:text-gray-50  transition ease-in-out duration-150'
                onClick="window.location.href='{{ route('posts.show', $post) }}'">
                Read More <x-icons.arrow-up-right
                    class="group-hover:translate-x-1 transition ease-in-out duration-150 group-hover:rotate-45" />
            </button>
        </div>

    </div>
</div>
