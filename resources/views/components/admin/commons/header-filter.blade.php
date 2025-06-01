@props([
    'routeIndex' => null,
    'routeDelete' => null,
    'isFilter' => false
])

@if ($routeIndex || $routeDelete)
    <div class="flex mt-5 items-center justify-between">
         @isset($routeIndex)
            <x-admin.commons.bulk-delete :routeDelete="$routeDelete"/>
        @endisset
         @isset($routeIndex)
            <x-admin.commons.search :routeIndex="$routeIndex" :isFilter="$isFilter"/>
        @endisset
    </div>
@endif
