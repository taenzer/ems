<x-app-layout>
    <x-slot name="header">
        <x-header heading="Neues Ticket Produkt erstellen"></x-header>
    </x-slot>
    <x-body>
        <x-body-box>
            <livewire:ticket-admin-form :editable="true" />
        </x-body-box>

    </x-body>
</x-app-layout>
