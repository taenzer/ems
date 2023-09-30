<x-app-layout>
    <x-slot name="header">
        <x-header heading="Produkte hinzufügen: {{ $event->name }}"></x-header>
    </x-slot>
    <x-body>

        <x-body-box>

            <form action="{{ route('events.products.store', ['event' => $event]) }}" method="post">
                @csrf
                <div class="flex gap-4">
                    @foreach ($product_sets as $type => $products)
                        <x-body-section :title="\App\Models\Product::getTypes()[$type] ?? $type" class="basis-2/4 ">
                            @foreach ($products as $i => $product)
                                <x-event-product-link
                                    :name="$product->name"
                                    :id="$product->id"
                                    :default_price="$product->default_price"
                                />
                            @endforeach
                        </x-body-section>
                    @endforeach
                </div>

                
                @error("products")
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    
                @enderror
                @error("products.*")
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    
                @enderror

                <x-primary-button>
                    Hinzufügen
                </x-primary-button>
            </form>
        </x-body-box>
    </x-body>
</x-app-layout>