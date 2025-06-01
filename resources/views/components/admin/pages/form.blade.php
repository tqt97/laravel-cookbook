<x-app-layout>
    <x-slot name="header">
        {{ $breadcrumb }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ $headerPage }}

                    <div class="bg-white border rounded-lg px-8 py-6 mx-auto my-8">
                        {{ $form }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
