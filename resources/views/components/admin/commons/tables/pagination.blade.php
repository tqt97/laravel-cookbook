@props([
    'items' => null
])

@if ($items)
    <div class="px-3 py-4">
        {{ $items->links() }}
    </div>
@endif
