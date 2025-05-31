@props(['post', 'comments'])

<div class="">
    <div class="p-6">
        <a href="{{ route('home') }}" class="text-md text-black rounded-md hover:text-blue-500">
            ← {{ __('common.back') }}
        </a>
        <h2 class="mt-5 text-xl md:text-3xl font-semibold mb-3">
            {{ $post->title}}
        </h2>

        <div class="flex items-center justify-between gap-4 text-sm text-gray-500 mb-4">
            <div class="flex items-center gap-2">
                <div class="flex items-center gap-1">
                    <x-icons.tag />
                    <span>{{ $post->category->name }}</span>
                </div>
                <div class="flex items-center gap-1">
                    <x-icons.message />
                    <span>1</span>
                </div>
                <div class="flex items-center gap-1">
                    <x-icons.calendar />
                    <span>{{ $post->created_at->diffForHumans() }}</span>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <div class="flex items-center gap-1 ">
                    <x-icons.eye />
                    {{ $post->view_count }} views
                </div>
                <form action="{{ route('like.toggle', ['type' => 'post', 'id' => $post->id]) }}" method="POST"
                    class="flex items-center gap-1">
                    @csrf
                    <button type="submit" class="flex items-center gap-1">
                        @if(auth()->check() && (bool)$post->likedBy(auth()?->user()))
                            <x-icons.heart class="text-red-500 fill-red-500" /> unlike
                        @else
                            <x-icons.heart /> like
                        @endif
                    </button>
                </form>
            </div>
        </div>

        <div class="text-gray-600 my-4">
            {!! $post->content !!}
        </div>

        <section class="bg-white dark:bg-gray-900 py-8 lg:py-16 antialiased">
            @auth
                <div class="mx-auto">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white">Discussion
                            ({{ $post->comments_count }})</h2>
                    </div>
                    <form class="mb-6" method="POST" action="{{ route('comments.store', $post) }}">
                        @csrf
                        <input type="hidden" name="parent_id" value="">
                        <x-input-error :messages="$errors->get('content')" class="mb-2" />
                        <div
                            class="py-2 px-4 mb-4 bg-white rounded-lg rounded-t-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                            <label for="comment" class="sr-only">Your comment</label>
                            <textarea id="content" rows="6" name="content"
                                class="px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800"
                                placeholder="Write a comment..." required>{{ old('content') }}</textarea>
                        </div>
                        <button type="submit"
                            class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center border text-gray-50 bg-gray-800 bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:text-white hover:bg-gray-900">
                            Post comment
                        </button>
                    </form>
                    {{-- list comment here --}}
                    @foreach ($comments as $comment)
                        <x-blogs.comment :comment="$comment" />
                    @endforeach
                </div>
            @else
                <div>
                    <p>Login to comment for this post.
                        <a href="{{ route('login') }}" class="text-blue-500 underline hover:text-blue-600">Login here</a>
                    </p>
                </div>
            @endauth
        </section>
    </div>
</div>
