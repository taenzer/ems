<x-app-layout>
    <x-slot name="header">
        <x-header heading="Produkt bearbeiten: {{ $product->name }}"></x-header>
    </x-slot>
    <x-body>
        <x-body-box>
            <form x-data="form()" action="{{ route('products.update', ['product' => $product]) }}" method="post"
                enctype="multipart/form-data"
                @formdata="updateFormData">
                @csrf
                @method('PATCH')
                <div class="flex gap-4">
                    <x-input.image-cropper name="image" label="Produktbild" @update="imageString = $event.detail"
                        src="{{ asset('storage/' . $product->image) }}" aspect_ratio="1.27"
                        class="basis-96 rounded-sm bg-gray-100 p-4" style="max-width: 400px;" />
                    <div class="grow">
                        <x-input name="name" label="Produktbezeichnung" value="{{ $product->name }}" />
                        <x-select name="type" label="Produktkategorie">
                            @foreach (\App\Models\Product::getTypes() as $type => $typeName)
                                <option value="{{ $type }}" {{ $type == $product->type ? 'selected' : '' }}>
                                    {{ $typeName }}</option> @endforeach
                </x-select>

                <x-input name="default_price" label="Standardpreis (EUR)" type="number" step="0.01"
                    value="{{ $product->default_price }}" />
                <x-primary-button>Speichern</x-primary-button>

                </div>

                </div>
            </form>
            <script>
                function form() {
                    return {
                        imageString: null,
                        updateFormData: function(event) {
                            const formData = event.formData;
                            formData.set('image', this.imageString);
                        },

                    };
                }
            </script>
        </x-body-box>

    </x-body>
</x-app-layout>
