
<x-app-layout>
    <x-slot name="header">
        <x-header heading="Produkte">
            <x-slot name="actions">
                <a href="{{ route('products.create') }}"><x-primary-button>Neues Produkt</x-primary-button></a>
            </x-slot>
        </x-header>
        
    </x-slot>

    <x-body>
        @foreach ($product_sets as $type => $products)
            <x-body-section :title="\App\Models\Product::getTypes()[$type] ?? $type">
                @foreach ($products as $product)
                    <x-body-box>
                        <div
                        class="grid-rows-1 gap-x-2"
                        style="display: grid;
                                grid-template-columns: 1fr auto auto; align-items: center;" >
                            <a href="{{ route('products.show', ['product' => $product])}}" style="grid-area: 1 1 1 1;" class="font-semibold">
                            {{ $product->name }}
                            </a>

                            <span style="grid-area: 1 / 2 / 2 / 3" class="cursor-default">@money($product->default_price)</span>
                            <span style="grid-area: 1 / 3 / 2 / 4">  <a href="{{ route('products.show', ['product' => $product])}}"><x-icon name="chevron-right"/></a> </span>
                            
                        </div>
                        
                    </x-body-box>
                @endforeach
            </x-body-section>

        @endforeach
        
        
    </x-body>

    
</x-app-layout>