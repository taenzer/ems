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

        <x-body-box>
            <h3 class="font-semibold mb-4">Temporärer Bug-Workaround</h3>
            <p class="mb-4">Auf Grund eines Fehlers in der EMS Ticketscan App werden Tickets die an der Abendkasse gekauft werden nicht automatisch eingecheckt. Da aber 
                davon auszugehen ist, dass Menschen die an der Abendkasse ein Ticket kaufen dieses auch nutzen, können über den folgenden Button alle Tickets
                die an der Abendkasse gekauft wurden eingecheckt werden.
            </p>
            <x-link-button link="{{ route('tickets.utils.boxofficeTicketCheckin', ['event' => $event]) }}">Abendkasse Ticket Checkin</x-link-button>
        </x-body-box>
    </x-body>
    
</x-app-layout>