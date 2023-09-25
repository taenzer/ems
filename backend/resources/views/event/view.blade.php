<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $event->name }}
        </h2>
    </x-slot>

    <x-body>
        <x-body-box>
            {{ __("You're logged in!") }}

        </x-body-box>
                <x-body-box>
            {{ __("You're logged in!") }}

        </x-body-box>
                <x-body-box>
            {{ __("You're logged in!") }}

        </x-body-box>
    </x-body>

    
</x-app-layout>