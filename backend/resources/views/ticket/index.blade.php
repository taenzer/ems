<x-app-layout>
    <x-slot name="header">
        <x-header heading="Tickets">
            <x-slot name="actions">
                <a href=""><x-primary-button>Ticket verkaufen</x-primary-button></a>
                <a href="{{ route('tickets.products.index') }}"><x-secondary-button>Ticket Produkte verwalten</x-secondary-button></a>
            </x-slot>
        </x-header>
    </x-slot>
    <x-body>
        <x-body-box>

        </x-body-box>

    </x-body>
</x-app-layout>
