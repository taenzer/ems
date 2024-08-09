@props(['name', 'value'])

<div class="flex items-center gap-2 cursor-pointer">
    <label for="{{ $name }}">
        <input type="checkbox" name="{{ $name }}" id="{{ $name }}" value="{{ $value }}" {{ $attributes(['value' => old($name)]) }}>
        {{ $slot }}
    </label>
</div>
