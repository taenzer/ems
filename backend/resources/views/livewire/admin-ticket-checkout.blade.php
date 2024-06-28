<div>
    <x-body-section title="Filter">
        <x-select name="event_id" label="Veranstaltung" wire:model="event" wire:change="getProducts">
        <option value="">Bitte wählen</option>
            @forelse (App\Models\Event::where("active", "1")->get() as $eventListEntry)
                <option value="{{ $eventListEntry->id }}">{{ $eventListEntry->name }}</option>
            @empty
                <option value="" disabled>Keine Veranstaltungen verfügbar</option>
            @endforelse
        </x-select>

    </x-body-section>
    <x-body-section title="Tickets auswählen">
        @if(isset($event))
        <div class="flex flex-col gap-4">
            @forelse($products as $product)
                <div class="bg-slate-100 rounded p-4 flex flex-col">
                    <div class="flex justify-between border-b pb-2 font-semibold">
                        <p>{{ $product->name }}</p>
                        <p>ZWISCHENSUMME     @money($this->calcTicketProductTotal($product->id))</p>
                    </div>
                    <div class="flex flex-col">
                    @forelse($product->prices as $price)
                        <div class="flex justify-between gap-4 py-4 border-b">
                            <div>
                                <p>{{ $price->category }}</p>
                                <p>@money($price->price)</p>
                            </div>
                            <div class="flex gap-4">
                                <div class="text-right">
                                    <p>Anzahl: {{ $this->getCartItemCount($product->id, $price->id) }}</p>
                                    <p>Summe: @money($this->getCartItemCount($product->id, $price->id) * $price->price)</p>
                                </div>
                                <div class="flex gap-2">
                                    <x-secondary-button type="button" wire:click="updateCart({{ $product->id }}, {{ $price->id }}, -1)">-</x-secondary-button>
                                    <x-secondary-button type="button" wire:click="updateCart({{ $product->id }}, {{ $price->id }}, 1)">+</x-secondary-button>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p>Keine Preiskategorien verfügbar</p>
                    @endforelse
                    </div>
                </div>
            @empty
            <p>Es stehen keine Tickets zum Verkauf zur Verfügung</p>
            @endforelse
            </div>
        @else 
            <p class="bg-slate-100 p-4 rounded">Bitte Veranstaltung auswählen!</p>
        @endif
    </x-body-section>
    <x-body-section title="Bestellung abschließen" class="mt-4">
        <div class="flex flex-col items-end">
        <p class="mb-2 uppercase font-semibold text-lg">GESAMTSUMME @money($this->calcOrderTotal())</p>
        <x-primary-button type="button" wire:click="createOrder">Bestellung abschließen</x-primary-button>
        </div>

    </x-body-section>
</div>
