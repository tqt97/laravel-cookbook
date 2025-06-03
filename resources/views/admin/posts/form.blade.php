@php
    $isEdit = $post->exists;
    $action = $isEdit ? route('admin.posts.update', $post) : route('admin.posts.store');
    $method = $isEdit ? 'PUT' : 'POST';
    $labelText = $isEdit ? 'common.edit' : 'common.create';
    $title = $isEdit ? 'post.pages.edit' : 'post.pages.create';
    $submitText = $isEdit ? 'common.update' : 'common.save';
@endphp

<x-admin.pages.form>
    <x-slot name="breadcrumb">
        <x-breadcrumb :items="[
        ['label' => 'post.title', 'href' => route('admin.posts.index')],
        ['label' => $labelText],
    ]" />
    </x-slot>

    <x-slot name="headerPage">
        <x-admin.commons.header-action :title="$title" :isBack="true" routeBack="admin.posts.index" />
    </x-slot>

    <x-slot name="form">
        <form method="POST" action="{{ $action }}" enctype="multipart/form-data">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif
            <div class="flex gap-4">
                <div class="w-3/4">
                    <div class="flex gap-4 items-center">
                        <div class="mb-4 w-1/2">
                            <x-admin.forms.text-input name="title" label="{{ __('post.form.title') }}" :value="$post->title"
                                :required="true" />
                        </div>
                        <div class="mb-4 w-1/2">
                            <x-admin.forms.text-input name="slug" label="{{ __('post.form.slug') }}" :value="$post->slug" />
                        </div>
                    </div>
                    <div class="mb-4 w-full">
                        <x-admin.forms.text-input name="excerpt" label="{{ __('post.form.excerpt') }}"
                            :value="$post->excerpt" />
                    </div>
                    <div class="mb-4 w-full">
                        <x-admin.forms.textarea name="content" :label="__('post.form.content')" :value="$post->content"
                            :required="true" />
                    </div>
                </div>
                <div class="w-1/4">
                    <div class="mb-4 w-full">
                        <x-admin.forms.select name="category_id" :label="__('post.form.category_id')" :options="$categories"
                            optionValue="id" optionLabel="name" :selected="old('category_id', $post->category_id)"
                            :required="true" placeholder="post.form.select_category" />
                    </div>
                    <div class="mb-4 w-full">
                        <x-admin.forms.multi-select name="tags" :label="__('post.form.tags')" :options="$tags"
                            :selected="$post->tags->pluck('id')->toArray()" placeholder="post.form.select_tags" />
                    </div>
                    <div class="flex gap-4 items-center">
                        <div class="mb-4 w-full">
                            <x-admin.forms.checkbox-group name="is_featured" :label="__('post.form.is_featured')"
                                :checked="old('is_featured', $post->is_featured)" />
                        </div>
                        <div class="mb-4 w-full">
                            <x-admin.forms.checkbox-group name="is_published" :label="__('post.form.is_published')"
                                :checked="old('is_published', $post->is_published)" />
                        </div>
                    </div>
                    <div class="mb-4 w-full">
                        <x-admin.forms.file-input name="image" :label="__('post.form.image')" accept="image/*" />
                    </div>
                </div>
            </div>
            <div class="mt-2">
                <x-primary-button type="submit">{{ __($submitText) }}</x-primary-button>
            </div>
        </form>
    </x-slot>

    @push('js')
        @vite('resources/js/admin/posts/form.js')
    @endpush
</x-admin.pages.form>
