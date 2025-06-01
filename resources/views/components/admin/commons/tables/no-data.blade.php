@props([
	'columns' => 2
])

<tr>
	<td colspan="{{ $columns }}" class="text-center py-3">
		{{ __('common.no_data') }}
	</td>
</tr>
