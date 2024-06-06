<div>
    <x-body-section title="Filter">
        <x-select name="active_status" label="Status der Veranstaltung">
            <option value="1">Aktiv</option>
            <option value="0">Inaktiv</option>
        </x-select>
        <x-select name="event_id" label="Veranstaltung">
            @forelse (App\Models\Event::all() as $event)
                <option value="{{ $event->id }}">{{ $event->name }}</option>
            @empty
                <option value="" disabled>Keine Veranstaltungen verfügbar</option>
            @endforelse
        </x-select>

    </x-body-section>
    <x-body-section title="Tickets auswählen">
        @forelse(App\Models\TicketProduct::all() as $product)
            <div class="bg-slate-100 rounded p-4 flex flex-col">
                <div class="flex justify-between border-b pb-2 font-semibold">
                    <p>{{ $product->name }}</p>
                    <p>SUMME @money(0)</p>
                </div>
                <div class="flex flex-col">
                @forelse($product->prices as $price)
                    <div class="flex">
                        <p>{{ $price->category }}</p>
                        <p>@money($price->price)</p>
                        <x-input type="number" name="quantity" placeholder="Anzahl" />
                        <p>Zeilensumme</p>
                    </div>
                    @empty
                    <p>Keine Preiskategorien verfügbar</p>
                @endforelse
                </div>
            </div>
        @empty
        <p>Es stehen keine Tickets zum Verkauf zur Verfügung</p>
        @endforelse
    </x-body-section>
    <x-body-section title="Bestellung abschließen">
    </x-body-section>
</div>
