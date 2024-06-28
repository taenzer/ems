<x-app-layout>
    <x-slot name="header">
        <x-header heading="Ticket Bestellungen">
            <x-slot name="beforeHeading">
                <a href="{{ route('tickets.dashboard') }}"><x-icon name="chevron-left"></x-icon></a>
            </x-slot>
        </x-header>
    </x-slot>
    <x-body>
        <x-body-box>
            
        </x-body-box>

    </x-body>
</x-app-layout>
