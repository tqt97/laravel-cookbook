@props(['group', 'permissions', 'selected' => []])

<div class="mb-4 border rounded-lg p-3 shadow bg-white w-full mx-auto">
    <label class="font-semibold text-lg flex items-center gap-2 mb-2 cursor-pointer">
        <input
            type="checkbox"
            class="cursor-pointer group-checkbox custom-checkbox accent-gray-800 focus:outline-none focus:ring-0 focus:shadow-outline rounded"
            data-group="{{ $group }}"
        >
        <span class="capitalize">{{ $group }}</span>
    </label>

    <div class="grid grid-cols-4 gap-2 pl-4">
        @foreach($permissions as $permission)
            <label class="flex items-center gap-2 hover:text-blue-800 px-2 py-1 rounded transition cursor-pointer">
                <input
                    type="checkbox"
                    name="permissions[]"
                    value="{{ $permission->id }}"
                    class="child-checkbox group-{{ $group }} custom-checkbox accent-gray-800 focus:outline-none focus:ring-0 focus:shadow-outline rounded"
                    {{ in_array($permission->id, $selected) ? 'checked' : '' }}
                >
                <span class="capitalize">{{ Str::after($permission->name, '.') }}</span>
            </label>
        @endforeach
    </div>
</div>
