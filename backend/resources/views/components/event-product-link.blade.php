@props(['name', 'id', 'default_price', 'checked' => false])

<label for="products[{{ $id }}]" x-data="{ active: {{ $checked ? "true" : "false" }} }">
    <div class="flex items-center justify-between py-3 px-4 bg-gray-100 rounded mb-6 cursor-pointer">
        <div class="flex gap-4 items-center">
            <input 
                class="border border-gray-400 p-2"
                type="checkbox"
                name="products[{{ $id }}]"
                id="products[{{ $id }}]"
                x-model="active"
                {{ $checked ? "checked" : "" }}
            />
            <span>{{$name}}</span>
        </div>
        <div>
            
            <input x-bind:disabled="!active" type="hidden" name="products[{{ $id }}][product_id]" value="{{ $id }}">
            <x-input.auto-width
                before="Preis:"
                after="€"
                name="products[{{ $id }}][price]"
                type="number" 
                max="9999"
                min="-9999"
                step="0.01"
                value="{{ $default_price }}"
                x-bind:disabled="!active"
            />

        </div>
    </div>
</label>