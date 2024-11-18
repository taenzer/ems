<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <strong>E</strong>VENT - <strong>M</strong>ANAGEMENT - <strong>S</strong>YSTEM
                    <p class="text-xs italic">by TNZ Dienstleistungen | Build @php echo config('build.nr') . " vom " . config('build.date') @endphp </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
