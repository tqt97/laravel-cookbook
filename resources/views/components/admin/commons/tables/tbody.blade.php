@forelse ($items as $item)
    {{ $slot }}
@empty
    <tr>
        <td colspan="{{ $columns ?? 1 }}" class="text-center py-3">
            {{ __('common.no_data') }}
        </td>
    </tr>
@endforelse
