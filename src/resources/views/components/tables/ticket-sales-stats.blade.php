@props(["ticketSaleStats"])

<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Ticket</th>
                        <th scope="col" class="px-6 py-3">Einzelpreis</th>
                        <th scope="col" class="px-6 py-3">Abendkasse Zuschlag</th>
                        <th scope="col" class="px-6 py-3">Anzahl Verkäufe</th>
                        <th scope="col" class="px-6 py-3">Umsatz</th>
                    </tr>
                </thead>
                
                <tbody>
                    @foreach($ticketSaleStats as $ticketName => $tickets)
                        @foreach($tickets as $boxoffice_fee => $ticketStats)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            @if($loop->first)
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white" rowspan="{{ $tickets->count() }}">{{ $ticketName }}</th>
                            <td class="px-6 py-4" rowspan="{{ $tickets->count() }}"> @money($ticketStats["price"])</td>
                            @endif
                            <td class="px-6 py-4"> @money($boxoffice_fee) </td>
                            <td class="px-6 py-4">{{ $ticketStats["count"] }}</td>
                            <td class="px-6 py-4"> @money($ticketStats["sum"])</td>
                        </tr>
                        @endforeach
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="font-semibold text-gray-900 dark:text-white">
                        <th scope="row" class="px-6 py-3 text-base" colspan="3">Summe</th>
                        <td class="px-6 py-3">
                            {{ 
                            $ticketSaleStats->map(function($tickets){
                                return $tickets->sum("count");
                            })->sum()
                        }}</td>
                        <td class="px-6 py-3">
                            @money( $ticketSaleStats->map(function($tickets){
                                return $tickets->sum("sum");
                            })->sum())
                        </td>
                    </tr>
                </tfoot>
            </table>