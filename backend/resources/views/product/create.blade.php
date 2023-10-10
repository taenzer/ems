<x-app-layout>
    <x-slot name="header">
        <x-header heading="Neues Produkt erstellen"></x-header>
    </x-slot>
    <x-body>
        <x-body-box>
            <form action="{{ route("products.store") }}" method="post" enctype="multipart/form-data">
                @csrf
                <x-input 
                name="name" 
                label="Produktbezeichnung"
                />
                <x-select 
                name="type" 
                label="Produktkategorie"
                placeholder="-- Bitte auswählen --"
                >
                    @foreach (\App\Models\Product::getTypes() as $type => $typeName)
                        <option value="{{ $type }}">{{ $typeName }}</option>
                    @endforeach
                </x-select>

                <x-input 
                name="default_price" 
                label="Standardpreis (EUR)"
                type="number"
                step="0.01"
                />

                <x-input.image-cropper
                name="image"
                label="Produktbild"
                />



                <x-primary-button>Speichern</x-primary-button>

            </form>
        </x-body-box>
       
    </x-body>
</x-app-layout>

