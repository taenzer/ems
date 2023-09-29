<x-app-layout>
    <x-slot name="header">
        <x-header heading="Produkte hinzufügen: {{ $event->name }}"></x-header>
    </x-slot>
    <x-body>
        <x-body-box>

            <form action="{{ route('events.products.store', ['event' => $event]) }}" method="post">
                @csrf
                @foreach (\App\Models\Product::all() as $i => $product)
                    <label for="products[{{ $i }}]">

                    <div class="flex items-center justify-between py-3 px-4 bg-gray-100 rounded mb-6 cursor-pointer">
                        <div class="flex gap-4 items-center">
                            <input 
                                class="border border-gray-400 p-2"
                                type="checkbox"
                                name="products[{{ $i }}]"
                                id="products[{{ $i }}]"
                                required
                            >
                            <span>{{$product->name}}</span>
                        </div>
                        <div>
                            <label for="products[{{ $i }}]['price']">Preis: </label>
                            <input type="hidden" name="products[{{ $i }}]['id']" value="{{ $product->id }}">
                            <input name="products[{{ $i }}]['price']" id="products[{{ $i }}]['price']" class="text-right border-0 p-0 bg-transparent italic" id="pr_price" type="number" max="99" min="-99" step="0.01" value="{{ $product->default_price }}">
                            <span>€</span>
                        </div>
                        
                        
                    
                        @error('pr')
                        <p class="text-red-500 text-xs mt-2">{{ message }}</p>
                    
                        @enderror
                    </div>

                </label>
                @endforeach
                
                

                <x-primary-button>
                    Hinzufügen
                </x-primary-button>
            </form>
        </x-body-box>
    </x-body>
</x-app-layout>