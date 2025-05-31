<div class="flex items-center justify-between p-4 border-b mb-4">
    {{-- Form Search --}}
    <form action="{{ route('home') }}" method="GET" class="relative w-full max-w-xs">
        <input type="search" name="search"
            class="w-full pr-10 rounded-md py-[6px] pl-3 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
            value="{{ request('search') }}" placeholder="{{ __('common.search_placeholder') }}" autocomplete="search" />
        <button type="submit"
            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-indigo-600">
            <x-icons.search class="w-5 h-5" />
        </button>

        {{-- preserve --}}
        <x-clients.preserve-filters />
    </form>

    {{-- Form filter nhỏ (limit, sort, direction) --}}
    <div class="flex gap-2">
        {{-- Limit --}}
        <form action="{{ route('home') }}" method="GET">
            <select name="limit" onchange="this.form.submit()"
                class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 py-[6px] cursor-pointer">
                @foreach ([5, 10, 20, 50, 100] as $value)
                    <option value="{{ $value }}" {{ request('limit', 10) == $value ? 'selected' : '' }}>
                        {{ $value }} {{ __('common.per_page') }}
                    </option>
                @endforeach
            </select>
            {{-- preserve filter --}}
            <x-clients.preserve-filters />

        </form>

        {{-- Sort --}}
        <form action="{{ route('home') }}" method="GET">
            <select name="sort" onchange="this.form.submit()"
                class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 py-[6px] cursor-pointer">
                <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>
                    {{ __('common.latest') }}
                </option>
                <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>
                    {{ __('common.title') }}
                </option>
            </select>
            {{-- preserve --}}
            <x-clients.preserve-filters />

        </form>

        {{-- Direction --}}
        <form action="{{ route('home') }}" method="GET">
            <select name="direction" onchange="this.form.submit()"
                class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 py-[6px] cursor-pointer">
                <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>
                    {{ __('common.desc') }}
                </option>
                <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>
                    {{ __('common.asc') }}
                </option>
            </select>
            {{-- preserve --}}
            <x-clients.preserve-filters />

        </form>
        {{-- Reset button --}}
        @if(request()->query->count() > 0)
            <a href="{{ route('home') }}"
                class="inline-flex items-center px-2 py-[6px] bg-gray-800 hover:bg-gray-900 text-white text-xs rounded-md cursor-pointer">
                {{ __('common.clear') }}
            </a>
        @endif
    </div>
</div>
