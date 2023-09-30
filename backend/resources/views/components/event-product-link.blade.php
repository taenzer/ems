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
            <label for="products[{{ $id }}][price]">Preis: </label>
            <input x-bind:disabled="!active" type="hidden" name="products[{{ $id }}][product_id]" value="{{ $id }}">
            <input x-bind:disabled="!active" name="products[{{ $id }}][price]" id="products[{{ $id }}][price]" class="text-right border-0 p-0 bg-transparent italic" id="pr_price" type="number" max="99" min="-99" step="0.01" value="{{ $default_price }}">
            <span>€</span>
        </div>
    </div>
</label>