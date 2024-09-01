<div>
    <div class="flex gap-2 mb-4">Gateways: 
        @foreach ($selectableGateways as $gw)
            <x-input.checkbox name="epsa.selectedGateways.{{$gw}}" wire:model.live="gateways.{{$gw}}" value="{{ $gw }}" wire:change="recalculateStats"><span
                    class="uppercase" >{{ $gw }}</span></x-input.checkbox>
        @endforeach
    </div>
    <div class="relative inline-grid grid-cols-{{ 2 + $events->count() }} grid-rows-{{ 2 + $products->count() }} gap-2 auto-cols-min grid-flow-row-dense w-auto content-center">
        <div class="row-start-1 col-start-1 {{ $cellclasses }} font-semibold">Produkte / Events</div>
        <div class="row-start-1 col-start-{{ 2 + $events->count() }} {{ $cellclasses }}">
            <livewire:searchable-select title="Veranstaltung hinzufügen" :selectables="$selectableEvents" maxVisible="5" @select="addEvent($event.detail.selected)"/>
        </div>
        <div class="row-start-{{ 2 + $products->count() }} col-start-1 {{ $cellclasses }}"><livewire:searchable-select title="Produkt hinzufügen" :selectables="$selectableProducts" maxVisible="5" @select="addProduct($event.detail.selected)"/></div>
        
        @foreach ($events as $index => $event)
            <div class="row-start-1 col-start-{{ $index + 2 }} {{ $cellclasses }} font-semibold"><p>{{  $event->name }}</p></div>
        @endforeach

        @foreach ($products as $index => $product)
            <div class="row-start-{{ $index + 2 }} col-start-1 {{ $cellclasses }} font-semibold"><p>{{  $product->name }}</p></div>
        @endforeach

        @foreach ($stats as $stat)
            <div class="row-start-{{ $stat['productIndex'] + 2 }} col-start-{{ $stat['eventIndex'] + 2 }} {{ $cellclasses }} hovercell">

                <p class="flex items-center gap-2 mb-2">
                    <span class="flex items-center gap-1 bg-slate-300 px-2 rounded-full" title="Anzahl verkauft"><x-icon name="grain"/> {{ $stat['itemsSoldTotal'] }} </span>
                    <span class="flex items-center gap-1 bg-slate-300 px-2 rounded-full" title="Umsatz"><x-icon name="payments"/> @money($stat['total']) </span>
                    <span class="flex items-center gap-1 bg-slate-300 px-2 rounded-full" title="Preiskategorien"><x-icon name="category"/> {{ count($stat['priceCategories']) }}</span>
                </p>
                <div class="pl-2 text-sm border-l ml-2 text-slate-600 border-l-slate-600 border-dotted">
                    @foreach ($stat["priceCategories"] as $pcat)
                        <p>{{ $pcat["itemsSold"] }}x @money($pcat["price"]) = @money($pcat["total"])</p>
                    @endforeach
                
                </div>
            </div>
        @endforeach

    </div>
</div>

