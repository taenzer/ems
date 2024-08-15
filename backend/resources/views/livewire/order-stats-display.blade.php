<div class="flex flex-col gap-6">
    <div class="flex gap-4">
        <p>für folgende Gateways:</p>
        @foreach ($gateways as $gw)
            <x-input.checkbox name="selectedGateways.{{$gw}}" wire:model.live="selectedGateways.{{$gw}}" value="{{ $gw }}" wire:change="calcStats"><span
                    class="uppercase" >{{ $gw }}</span></x-input.checkbox>
        @endforeach
    </div>
    <div class="flex gap-2">
        <x-stat-card title="Anzahl Bestellungen" :main="$orderCount"/>
        <x-stat-card title="Ø Bestellwert" :money="true" :main="$avgTotal"/>
        <x-stat-card title="Bestseller" :main="$bestsellers->keys()->first()"/>
        <x-stat-card title="Umsatz" :money="true" :main="$money"/>
    </div>
</div>
