<div>
<p class="rotate-45 relative"><x-misc.icon name="chevron-right" /></p>

<div class="relative overflow-x-auto sm:rounded-lg border">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col">
                    <span class="sr-only">Details</span>
                </th>   
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sortByColumn('id')">
                    <span class="flex items-center">
                        ID
                        @if($sortByCol == "id")
                            <x-misc.icon name="chevron-right" class="inline-block {{ $sortByAsc ? '-rotate-90' : 'rotate-90' }}"/>
                        @endif
                    </span>
                </th>
                <th scope="col" class="px-6 py-3">
                    Artikel
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sortByColumn('created_at')">
                    <span class="flex items-center">
                        Zeitstempel
                        @if($sortByCol == "created_at")
                            <x-misc.icon name="chevron-right" class="inline-block {{ $sortByAsc ? '-rotate-90' : 'rotate-90' }}"/>
                        @endif
                    </span>
                    
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sortByColumn('total')">
                    <span class="flex items-center">
                        Summe
                        @if($sortByCol == "total")
                            <x-misc.icon name="chevron-right" class="inline-block {{ $sortByAsc ? '-rotate-90' : 'rotate-90' }}"/>
                        @endif
                    </span>
                    
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sortByColumn('gateway')">
                    <span class="flex items-center">
                        Gateway
                        @if($sortByCol == "gateway")
                            <x-misc.icon name="chevron-right" class="inline-block {{ $sortByAsc ? '-rotate-90' : 'rotate-90' }}"/>
                        @endif
                    </span>
                    
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600" wire:key="order-{{ $order->id }}">
                    <td class="px-4 py-4 flex">
                        <x-misc.icon name="chevron-right" class="bg-slate-100 cursor-pointer p-1 rounded"/>
                    </td>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $order->id }}
                    </th>
                    <td class="px-6 py-4">
                        {{ $order->items()->sum("quantity") }} Artikel
                    </td>
                    <td class="px-6 py-4">
                        {{ $order->created_at->format("d.m.Y H:i:s") }} Uhr
                    </td>
                    <td class="px-6 py-4">
                        @money($order->total)
                    </td>
                    <td class="px-6 py-4">
                        <x-misc.gateway-display :gateway="$order->gateway" :member_name="$order->getMemberNameIfPresent()"/>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
