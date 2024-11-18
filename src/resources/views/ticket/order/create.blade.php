<x-app-layout>
    <x-slot name="header">
        <x-header heading="Neue Ticketbestellung">
            <x-slot name="beforeHeading">
                <a href="{{ route('tickets.orders.index') }}"><x-misc.icon name="chevron-left"></x-misc.icon></a>
            </x-slot>
        </x-header>
    </x-slot>
    <x-body>
        <x-body-box>
            <livewire:admin-ticket-checkout />
        </x-body-box>

    </x-body>
</x-app-layout>
