@props([
    'title' => 'common.list',
    'route' => null,
    'label' => 'common.create',
    'isBack' => false,
    'routeBack' => null
])

<div class="flex items-center justify-between">
    <h2 class="font-bold text-xl">{{ __($title) }}</h2>
    @if ($isBack)
        <a href="{{ route($routeBack) }}"
            class="px-4 py-[10px] text-sm bg-gray-800 hover:bg-gray-900 text-white rounded-md dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
            ← {{ __('common.back') }}
        </a>
    @else
        <a href="{{ route($route) }}">
            <x-primary-button>
                <x-icons.plus class="mr-2 text-white" /> {{ __($label) }}
            </x-primary-button>
        </a>
    @endif
</div>
