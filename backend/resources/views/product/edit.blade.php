<x-app-layout>
    <x-slot name="header">
        <x-header heading="Produkt bearbeiten: {{$product->name}}"></x-header>
    </x-slot>
    <x-body>
        <x-body-box>
            <form action="{{ route("products.update", ["product" => $product]) }}" method="post">
                @csrf
                @method("PATCH")

                <x-input 
                name="name" 
                label="Produktbezeichnung"
                value="{{ $product->name }}"
                />
                <x-select 
                name="type" 
                label="Produktkategorie"
                >
                    @foreach (\App\Models\Product::getTypes() as $type => $typeName)
                        <option value="{{ $type }}" {{ $type == $product->type ? "selected" : ""}}>{{ $typeName }}</option>
                    @endforeach
                </x-select>

                        <x-input 
                name="default_price" 
                label="Standardpreis (EUR)"
                type="number"
                step="0.01"
                value="{{ $product->default_price }}"
                />
                <x-primary-button>Speichern</x-primary-button>

            </form>
        </x-body-box>
       
    </x-body>
</x-app-layout>

