@props([
    'center' => false,
    'sticky' => false,
    'class' => ''
])

<td {{ $attributes->merge([
    'class' => 'td text-sm text-gray-800 whitespace-nowrap ' .
                ($center ? 'text-center ' : '') .
                ($sticky ? 'sticky left-0 z-10 bg-white ' : '') .
                $class
]) }}>
    {{ $slot }}
</td>
