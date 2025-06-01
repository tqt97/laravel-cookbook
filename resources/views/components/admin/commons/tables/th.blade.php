@props([
    'center' => false,
    'sticky' => false,
    'class' => ''
])

<th {{ $attributes->merge([
    'class' => 'th font-medium text-left bg-gray-800 text-white text-sm whitespace-nowrap ' .
                ($center ? 'text-center ' : '') .
                ($sticky ? 'sticky left-0 z-10 ' : '') .
                $class
]) }}>
    {{ $slot }}
</th>
