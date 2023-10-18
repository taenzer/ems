<x-app-layout>
    <x-slot name="header">
        <x-header heading="Neues Produkt erstellen"></x-header>
    </x-slot>
    <x-body>
        <x-body-box>
            <form x-data="form()" action="{{ route("products.store") }}" method="post" enctype="multipart/form-data"
                @formdata="updateFormData" @submit="prevS">
                @csrf
                <div class="flex gap-4">
                    <x-input.image-cropper name="image" label="Produktbild" @update="imageString = $event.detail" class="basis-96 bg-gray-100 p-4 rounded-sm" style="max-width: 400px;" />
                    <div class="grow pt-4">
                        <x-input name=" name" label="Produktbezeichnung" />
                        <x-select name="type" label="Produktkategorie" placeholder="-- Bitte auswählen --">
                            @foreach (\App\Models\Product::getTypes() as $type => $typeName)
                            <option value="{{ $type }}">{{ $typeName }}</option>
                            @endforeach
                        </x-select>

                        <x-input name="default_price" label="Standardpreis (EUR)" type="number" step="0.01" />
                        <x-primary-button>Speichern</x-primary-button>
                    </div>
                </div>

                

            </form>
            <script>
            function form() {
                return {
                    imageString: null,
                    updateFormData: function(event){
                        const formData = event.formData;
                        formData.set('image', this.imageString);
                    },

                };
            }
            </script>
        </x-body-box>

    </x-body>
</x-app-layout>