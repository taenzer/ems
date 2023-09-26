@props(['name', 'label', 'placeholder'])
<div class="mb-6">
    <label 
        class="block mb-2  uppercase font-bold text-xs text-gray-700" 
        for="{{ $name }}">
        {{ $label }}
    </label>

    <select 
        class="border border-gray-400 p-2 w-full rounded-md"

        name="{{ $name }}"
        id="{{ $name }}"
        {{ $attributes(['value' => old($name)]) }}
        required
    >   
        @isset($placeholder)
            <option disabled selected value="">{{ $placeholder }}</option>
        @endisset
        
    {{ $slot }}
    </select>

    @error($name)
    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>

    @enderror
</div>