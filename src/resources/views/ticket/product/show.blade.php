<x-app-layout>
    <x-slot name="header">
        <x-header heading="Ticket Produkt Details">
            <x-slot name="beforeHeading">
                <a href="{{ route('tickets.products.index') }}" class="opacity-50">
                    <x-icon name="chevron-left" />
                </a>
            </x-slot>
            <x-slot name="actions">
                <a href="{{ route("tickets.products.edit", ["product" => $product]) }}"><x-secondary-button>Bearbeiten</x-secondary-button></a>
            </x-slot>
        </x-header>

    </x-slot>
    <x-body>
        <x-body-box>
            <livewire:ticket-admin-form :product="$product" :editable="false"/>
        </x-body-box>

    </x-body>
</x-app-layout>