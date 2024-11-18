<x-app-layout>
    <x-slot name="header">
        <x-header heading="EMS Analytics: Event Produkt Verkäufe">
        </x-header>
    </x-slot>
    <x-body>
        <x-body-box class="overflow-visible">
            <h3 class="mb-4 font-semibold">Produktverkäufe zwischen Events vergleichen</h3>
            <livewire:event-product-sales-analytics :selectableEvents="$events" :selectableProducts="$products"/>
        </x-body-box>
    </x-body>
</x-app-layout>
