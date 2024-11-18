<x-app-layout>
    <x-slot name="header">
        <x-header heading="{{ $product->name }}">
            <x-slot name="beforeHeading">
                <a href="{{ route("products.index")}}" class="opacity-50">
                    <x-misc.icon name="chevron-left"/>
                </a>
            </x-slot>
            <x-slot name="actions">
                <a href="{{ route('products.edit', ['product' => $product]) }}">
                    <x-primary-button>Bearbeiten</x-primary-button>
                </a>
                <a href="{{ route('products.create') }}">
                    <x-secondary-button>Neues Produkt</x-secondary-button>
                </a>
            </x-slot>
        </x-header>
    </x-slot>

    <x-body>
       
        <x-body-box>
            <h3 class="mb-2 font-semibold">Produktdaten</h3>
            <div >
                <img src="{{ asset('storage/' . $product->image) }}" alt="Produktbild">
            </div>
            <table>
                <thead>
                    <tr>
                        <td>Produkttyp</td>
                        <td>Standardpreis</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            {{ $product->type() }}
                        </td>
                        <td>
                            @money($product->default_price) 
                        </td>
                    </tr>
                </tbody>
            </table>
        </x-body-box>
        <x-body-box>
            <h3 class="mb-2 font-semibold">Verkaufsstatistik</h3>

        </x-body-box>
        <x-body-box>
            <h3 class="mb-2 font-semibold">Verknüpfte Events</h3>

        </x-body-box>

    </x-body>

    
</x-app-layout>