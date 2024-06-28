<x-app-layout>
    <x-slot name="header">
        <x-header heading="Ticket Bestellungen">
            <x-slot name="beforeHeading">
                <a href="{{ route('tickets.dashboard') }}"><x-icon name="chevron-left"></x-icon></a>
            </x-slot>
            <x-slot name="actions">
                <a href="{{ route('tickets.orders.create') }}"><x-primary-button>Neue Bestellung</x-primary-button></a>
            </x-slot>
        </x-header>
    </x-slot>
    <x-body>
        @forelse($orders as $order)
        <a href="{{route("tickets.orders.show", ["ticketOrder" => $order])}}">
            <x-body-box >
                <div class="flex justify-between gap-4 items-center">
                    <div>
                        <p><span class="font-semibold">Bestellung #{{ $order->id }}</span> vom {{ $order->created_at->format("d.m.Y H:i:s") }} Uhr </p>
                        <div><x-badge>Tickets: {{ $order->tickets->count() }}</x-badge> <x-badge>Gateway: {{ $order->gateway }}</x-badge></div>
                    </div>
                    <div class="flex gap-2 items-center">
                        @money($order->total)
                        <x-icon name="chevron-right"></x-icon>
                    </div>
                    </div>
            </x-body-box>
        </a>
        @empty

        @endforelse


    </x-body>
</x-app-layout>
