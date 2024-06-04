<x-app-layout>
    <x-slot name="header">
        <x-header heading="Ticket Produkt bearbeiten"></x-header>
    </x-slot>
    <x-body>
        <x-body-box>
            <livewire:ticket-admin-form :product="$product" :editable="true"/>
        </x-body-box>

    </x-body>
</x-app-layout>