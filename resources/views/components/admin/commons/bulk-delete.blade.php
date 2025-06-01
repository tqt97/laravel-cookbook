@props([
    'routeDelete' => null
])

<div class="flex items-center gap-1">
    @isset($routeDelete)
        <form id="bulk-delete-form" method="POST" action="{{ route($routeDelete) }}">
            @csrf
            @method('DELETE')
            <div id="bulk-delete-inputs"></div>
            <x-primary-button type="submit" aria-label="{{ __('common.bulk_delete') }}" id="bulk-delete-button"
                style="display: none;" class="text-white rounded-md transition
                                        bg-red-500 hover:bg-red-600
                                        disabled:opacity-0 disabled:cursor-not-allowed"
                onclick="return confirm('{{ __('common.bulk_delete_confirm') }}')">
                {{ __('common.bulk_delete') }}
            </x-primary-button>
        </form>
        <div id="selected-count" class="text-gray-700" style="display: none;">
            {{ __('common.select') }}
            <strong id="selected-count-number"></strong>
            {{ __('common.items') }}
        </div>
    @endisset
</div>
