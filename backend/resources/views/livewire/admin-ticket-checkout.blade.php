<div>
    <x-body-section title="Filter">
        <x-select name="event_id" label="Veranstaltung" wire:model="event" wire:change="getProducts">
        <option value="" selected>Bitte wählen</option>
            @forelse (App\Models\Event::where("active", "1")->get() as $eventListEntry)
                <option value="{{ $eventListEntry->id }}">{{ $eventListEntry->name }}</option>
            @empty
                <option value="" disabled>Keine Veranstaltungen verfügbar</option>
            @endforelse
        </x-select>

    </x-body-section>
    <x-body-section title="Tickets auswählen">
        @if(isset($event))
            @forelse($products as $product)
                <div class="bg-slate-100 rounded p-4 flex flex-col">
                    <div class="flex justify-between border-b pb-2 font-semibold">
                        <p>{{ $product->name }}</p>
                        <p>SUMME @money($this->calcTicketProductTotal($product->id))</p>
                    </div>
                    <div class="flex flex-col">
                    @forelse($product->prices as $price)
                        <div class="flex">
                            <p>{{ $price->category }}</p>
                            <p>@money($price->price)</p>
                            <button type="button" wire:click="updateCart({{ $product->id }}, {{ $price->id }}, -1)">-</button>
                            <x-input type="number" name="quantity" placeholder="Anzahl" readonly value="{{ $this->getCartItemCount($product->id, $price->id) }}"/>
                            <button type="button" wire:click="updateCart({{ $product->id }}, {{ $price->id }}, 1)">+</button>
                            <p>Zeilensumme: @money($this->getCartItemCount($product->id, $price->id) * $price->price)</p>
                        </div>
                        @empty
                        <p>Keine Preiskategorien verfügbar</p>
                    @endforelse
                    </div>
                </div>
            @empty
            <p>Es stehen keine Tickets zum Verkauf zur Verfügung</p>
            @endforelse
        @else 
            <p>Bitte Veranstaltung auswählen!</p>
        @endif
    </x-body-section>
    <x-body-section title="Bestellung abschließen">
        SUMME: @money($this->calcOrderTotal())
        <x-primary-button type="button" wire:click="createOrder">Bestellung speichern</x-primary-button>
    </x-body-section>
</div>
