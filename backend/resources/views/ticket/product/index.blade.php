<x-app-layout>
    <x-slot name="header">
        <x-header heading="Ticket Produkte">
            <x-slot name="actions">
                <a href="{{ route('tickets.products.create') }}"><x-primary-button>Neues Ticket
                        Produkt</x-primary-button></a>
            </x-slot>
        </x-header>
    </x-slot>
    <x-body>

        @foreach ($products as $product)
            <a href="{{ route('tickets.products.show', ['product' => $product]) }}">
                <x-body-box>
                    <div class="grid-rows-1 gap-x-2"
                        style="display: grid;
                                grid-template-columns: 1fr auto auto; align-items: center;">
                        <div style="grid-area: 1 1 1 1;">
                            <span class="font-semibold" >{{ $product->name }}</span>
                            <x-badge>{{ $product->permits()->count() }} Permits</x-badge>
                            <x-badge>{{ $product->prices()->count() }} Prices</x-badge>
                            <x-badge>{{ $product->design->name }}</x-badge>
                        </div>
                        <span style="grid-area: 1 / 3 / 2 / 4"> <x-icon name="chevron-right" /></span>
                    </div>
                </x-body-box></a>
        @endforeach


    </x-body>
</x-app-layout>
