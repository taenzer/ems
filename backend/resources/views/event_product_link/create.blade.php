<x-app-layout>
    <x-slot name="header">
        <x-header heading="Produkte hinzufügen: {{ $event->name }}"></x-header>
    </x-slot>
    <x-body>

        <x-body-box>
            @if($product_sets->isNotEmpty())
                <form action="{{ route('events.products.store', ['event' => $event]) }}" method="post">
                    @csrf
                    <div class="flex gap-4">
                        @foreach ($product_sets as $type => $products)
                            <x-body-section :title="\App\Models\Product::getTypes()[$type] ?? $type" class="basis-2/4 grow">
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
                    <a href="{{ route("events.show", ["event" => $event]) }}">
                        <x-secondary-button>Abbrechen</x-secondary-button>
                    </a>
                </form>                
            @else
                <x-notification type="warning" class="mb-6">
                    Es existieren keine Produkte die noch nicht mit dieser Veranstaltung verknüpft wurden!
                    <x-slot name="actions">
                        <a href="{{ route("products.create") }}">Produkt erstellen</a>
                    </x-slot>
                </x-notification>
                <a href="{{ route("events.show", ["event" => $event]) }}">
                    <x-secondary-button>Zurück</x-secondary-button>
                </a>
                
            @endif
        </x-body-box>
    </x-body>
</x-app-layout>