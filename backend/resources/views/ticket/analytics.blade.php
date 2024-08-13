<x-app-layout>
        <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Ticket Analytics: {{ $event->name }}
        </h2>
    </x-slot>
    <x-body>
        <x-body-box>
            
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Gateway</th>
                        <th scope="col" class="px-6 py-3">Ticket</th>
                        <th scope="col" class="px-6 py-3">Anzahl Verkäufe</th>
                        <th scope="col" class="px-6 py-3">Anzahl Check Ins</th>
                    </tr>
                </thead>
                
                <tbody>
                    @foreach($ticketStatsByGateway as $gateway => $tickets)
                        @foreach($tickets as $ticket => $ticketStats)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            @if($loop->first)
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white" rowspan="{{ $tickets->count() }}">{{ $gateway }}</th>
                            @endif
                            <td class="px-6 py-4">{{ $ticket }}</td>
                            <td class="px-6 py-4">{{ $ticketStats["sells"] }}</td>
                            <td class="px-6 py-4">{{ $ticketStats["checkins"] }}</td>
                        </tr>
                        @endforeach
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="font-semibold text-gray-900 dark:text-white">
                        <th scope="row" class="px-6 py-3 text-base" colspan="2">Summe</th>
                        <td class="px-6 py-3">{{ 
                            $ticketStatsByGateway->map(function($tickets){
                                return $tickets->sum('sells');
                            })->sum()
                        }}</td>
                        <td class="px-6 py-3">{{ 
                            $ticketStatsByGateway->map(function($tickets){
                                return $tickets->sum('checkins');
                            })->sum()
                        }}</td>
                    </tr>
                </tfoot>
            </table>

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