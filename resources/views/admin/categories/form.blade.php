@php
    $isEdit = $category->exists;
    $action = $isEdit ? route('admin.categories.update', $category) : route('admin.categories.store');
    $method = $isEdit ? 'PUT' : 'category';
    $labelText = $isEdit ? 'common.edit' : 'common.create';
    $title = $isEdit ? 'category.pages.edit' : 'category.pages.create';
    $submitText = $isEdit ? 'common.update' : 'common.save';
@endphp

<x-admin.pages.form>
    <x-slot name="breadcrumb">
        <x-breadcrumb :items="[
        ['label' => 'category.title', 'href' => route('admin.categories.index')],
        ['label' => $labelText],
    ]" />
    </x-slot>

    <x-slot name="headerPage">
        <x-admin.commons.header-action :title="$title" :isBack="true" routeBack="admin.categories.index" />
    </x-slot>

    <x-slot name="form">
        <form method="POST" action="{{ $action }}">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif
            <div class="flex gap-4 items-center">
                <div class="mb-4 w-1/2">
                    <x-admin.forms.text-input name="name" label="{{ __('category.form.name') }}"
                        :value="$category->name" :required="true" />
                </div>
                <div class="mb-4 w-1/2">
                    <x-admin.forms.text-input name="slug" label="{{ __('category.form.slug') }}"
                        :value="$category->slug" />
                </div>
            </div>
            <div class="flex gap-4 items-center">
                <div class="mb-4 w-1/2">
                    <x-admin.forms.select name="parent_id" :label="__('category.form.parent_id')"
                        :options="$categoryOptions" optionValue="id" optionLabel="name" :selected="old('parent_id', $category->parent_id)" placeholder="category.form.select_category" />
                </div>
                <div class="mb-4 w-1/2">
                    <x-admin.forms.number-input name="position" label="{{ __('category.form.position') }}"
                        :value="$category->position" min="0" />
                </div>
            </div>
            <div class="mb-4 w-full">
                <x-admin.forms.checkbox-group name="is_active" :label="__('category.form.is_active')"
                    :checked="old('is_active', $category->is_active)" />
            </div>

            <div class="mt-2">
                <x-primary-button type="submit">{{ __($submitText) }}</x-primary-button>
            </div>
        </form>
    </x-slot>
</x-admin.pages.form>
