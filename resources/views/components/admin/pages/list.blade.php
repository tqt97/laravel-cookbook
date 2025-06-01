<x-app-layout>
    <x-slot name="header">
        {{ $breadcrumb }}
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @isset($headerPage)
                        {{ $headerPage }}
                    @endisset
                    @isset($headerAction)
                        {{ $headerAction }}
                    @endisset
                    <div
                        class="shadow-md rounded-md mt-5 overflow-x-auto scrollbar-thin scrollbar-thumb-gray-200 scrollbar-track-gray-200">
                        <table class="min-w-max w-full table-striped">
                            <thead>
                                <tr class="bg-gray-800 text-white text-left relative">
                                    @isset($thead)
                                        {{ $thead }}
                                    @endisset
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @isset($tbody)
                                    {{ $tbody }}
                                @endisset
                            </tbody>
                        </table>
                    </div>
                    @isset($pagination)
                        {{ $pagination }}
                    @endisset
                </div>
            </div>
        </div>
    </div>
        @push('js')
        @vite('resources/js/admin/pages/list.js')
    @endpush
</x-app-layout>
