<x-app-layout>
    <x-slot name="header">
        <x-header heading="Neuer Ticketverkauf">
            <x-slot name="beforeHeading">
                <a href="{{ route('tickets.index') }}"><x-icon name="chevron-left"></x-icon></a>
            </x-slot>
        </x-header>
    </x-slot>
    <x-body>
        <x-body-box>
            <livewire:admin-ticket-checkout />
        </x-body-box>

    </x-body>
</x-app-layout>
