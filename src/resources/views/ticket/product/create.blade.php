<x-app-layout>
    <x-slot name="header">
        <x-header heading="Neues Ticket Produkt erstellen">
            <x-slot name="beforeHeading">
                <a href="{{ route('tickets.products.index') }}" class="opacity-50">
                    <x-misc.icon name="chevron-left" />
                </a>
            </x-slot>
        </x-header>
    </x-slot>
    <x-body>
        <x-body-box>
            <livewire:ticket-admin-form :editable="true" />
        </x-body-box>

    </x-body>
</x-app-layout>
