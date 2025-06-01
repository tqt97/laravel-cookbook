@props([
    'routeIndex' => null,
    'isFilter' => false
])

@isset($routeIndex)
    <div class="flex items-center gap-1">
        @if ($isFilter)
            <form method="GET" action="{{ route($routeIndex) }}">
                @foreach(request()->except('status') as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                <select name="status" onchange="this.form.submit()" class="rounded-md">
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>
                        {{ __('common.active') }}
                    </option>
                    <option value="trashed" {{ request('status') === 'trashed' ? 'selected' : '' }}>
                        {{ __('common.trashed') }}
                    </option>
                    <option value="all">{{ __('common.all') }}</option>
                </select>
            </form>
        @endif

        <form action="{{ route($routeIndex) }}" method="GET" class="flex items-center gap-1">
            <input type="search" id="search" class="w-full rounded-md py-[8px]" name="search"
                value="{{ request('search') }}" placeholder="{{ __('common.search_placeholder') }}" required
                autocomplete="search" />
            <x-primary-button type="submit">
                <x-icons.search class="mr-1 text-white" /> {{ __('common.search') }}
            </x-primary-button>
        </form>
        <a href="{{ route($routeIndex) }}" id="clear-filters-button" class="hidden">
            <x-primary-button>
                <x-icons.x-mark class="mr-1 text-white" />{{ __('common.reset') }}
            </x-primary-button>
        </a>
    </div>
@endisset
