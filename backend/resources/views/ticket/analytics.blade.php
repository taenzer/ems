<x-app-layout>
        <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Ticket Analytics: {{ $event->name }}
        </h2>
    </x-slot>
    <x-body>
        <x-body-box>
            <h3 clasS="font-semibold mb-4">Besucherzahlen</h3>
            <x-tables.ticket-guest-stats :ticketStatsByGateway="$ticketStatsByGateway"/>
        </x-body-box>

        <x-body-box>
            <h3 clasS="font-semibold mb-4">Umsätze</h3>
            <x-tables.ticket-sales-stats :ticketSaleStats="$ticketSaleStats" />
        </x-body-box>
    </x-body>
    
</x-app-layout>