@php
    $isEdit = $post->exists;
    $action = $isEdit ? route('admin.posts.update', $post) : route('admin.posts.store');
    $method = $isEdit ? 'PUT' : 'POST';
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $post->exists ? __('common.edit') : __('common.create') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold mb-4">
                            {{ $isEdit ? __('post.pages.edit') : __('post.pages.create') }}
                        </h2>
                        <a href="{{ route('admin.posts.index') }}"
                            class="px-4 py-[10px] text-sm bg-gray-800 hover:bg-gray-900 text-white rounded-md dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                            ← {{ __('common.back') }}
                        </a>
                    </div>

                    <div class="bg-white border rounded-lg px-8 py-6 mx-auto my-8">
                        <form method="POST" action="{{ $action }}" enctype="multipart/form-data">
                            @csrf
                            @if($isEdit)
                                @method('PUT')
                            @endif

                            <div class="flex gap-4 items-center">
                                <div class="mb-4 w-full">
                                    <x-forms.label name="title" :label="__('post.form.title')" required />
                                    <x-text-input id="title" class="mt-1 w-full" type="text" name="title"
                                        value="{{ old('title', $post->title) }}" required />
                                </div>
                                <div class="mb-4 w-full">
                                    <x-forms.label name="slug" :label="__('post.form.slug')" />
                                    <x-text-input id="slug" class="mt-1 w-full" type="text" name="slug"
                                        value="{{ old('slug', $post->slug) }}" />
                                </div>
                            </div>

                            <div class="flex gap-4 items-center">
                                <div class="mb-4 w-full">
                                    <x-forms.label name="category_id" :label="__('post.form.category_id')" required />
                                    <select name="category_id" id="category_id" class="form-select w-full mt-1">
                                        <option value="">{{ __('post.form.select_category') }}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4 w-full">
                                    <x-forms.label name="image" :label="__('post.form.image')" />
                                    <input type="file" name="image" id="image" accept="image/*">
                                </div>
                            </div>

                            <div class="flex gap-4 items-center">
                                <div class="mb-4 w-full">
                                    <x-forms.label name="excerpt" :label="__('post.form.excerpt')" />
                                    <x-text-input id="excerpt" class="mt-1 w-full" type="text" name="excerpt"
                                        value="{{ old('excerpt', $post->excerpt) }}" />
                                </div>
                            </div>

                            {{-- Tags --}}
                            <div class="flex gap-4 items-center">
                                <div class="mb-4 w-1/2">
                                    <x-forms.label name="tags" :label="__('post.form.tags')" />
                                    {{-- <div class="flex items-center gap-2 mb-1">
                                        <button type="button" onclick="clearTags()"
                                            class="text-sm text-red-500 hover:underline">
                                            {{ __('Bỏ chọn tất cả') }}
                                        </button>
                                    </div> --}}
                                    <select name="tags[]" id="tags" multiple class="form-multiselect w-full mt-1">
                                        <option value="__none__">{{ __('post.form.select_tags') }}</option>
                                        @foreach ($tags as $tag)
                                            <option value="{{ $tag->id }}" {{ in_array($tag->id, old(
                                                'tags',
                                                $post->tags->pluck('id')->toArray() ?? []
                                            )) ? 'selected' : '' }}>
                                                {{ $tag->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="flex gap-4 items-center">
                                <div class="mb-4 w-full">
                                    <x-forms.label name="content" :label="__('post.form.content')" required />
                                    <textarea id="content" rows="5" class="mt-1 w-full rounded-md"
                                        name="content">{{ old('content', $post->content) }}</textarea>
                                </div>
                            </div>

                            <div class="flex gap-4 items-center">
                                <div class="mb-4 w-1/2">
                                    <x-forms.label name="is_featured" :label="__('post.form.is_featured')" />
                                    <x-forms.checkbox name="is_featured" :checked="old('is_featured', $post->is_featured)" />
                                </div>
                                <div class="mb-4 w-1/2">
                                    <x-forms.label name="is_published" :label="__('post.form.is_published')" />
                                    <x-forms.checkbox name="is_published" :checked="old('is_published', $post->is_published)" />
                                </div>
                            </div>

                            <div class="flex gap-4 items-center mt-2">
                                <x-primary-button type="submit">{{ __('common.save') }}</x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        @vite('resources/js/admin/posts/edit.js')
    @endpush
</x-app-layout>
