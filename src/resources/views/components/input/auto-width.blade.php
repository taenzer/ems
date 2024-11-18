@props(['before' => '', 'name', 'after' => '', 'value'])
<div class="auto-width-input-wrap flex items-center justify-end gap-2 relative" x-data="{input: {{ $value }}, width: $refs.textwidth.offsetWidth}">
    
    <span>{{ $before }} </span>                            
    <input 
        class="auto-width-input border-0 p-0 bg-transparent no-arrows border-b border-solid leading-none text-right !shadow-none"
        type="number"
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $attributes }}
        step="0.01"
        x-model="input"
        x-ref="in"
        x-bind:style = "'box-shadow: none !important; min-width: 0.5rem; width: ' + width + 'px'"
        @input="width = $refs.textwidth.offsetWidth"
        
    >
    <span class="after-auto-width-input">{{ $after }}</span>
    <span x-text="input" x-ref="textwidth" class="absolute -z-50 opacity-0">{{ $value }}</span>
    

    @error($name)
    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
    @enderror
                                
</div>