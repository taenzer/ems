<div>
    <form wire:submit="save">
        @csrf
        <x-body-section title="Allgemeine Ticketoptionen">
            <x-input label="Ticket Name" name="name" wire:model="name" required />
            <x-input type="number" label="Anzahl verfügbar" name="tixAvailable" wire:model="tixAvailable" required />
        </x-body-section>

        <x-body-section title="Preiskategorien" class="pb-4">
            @foreach ($pricings as $key => $pricing)
                <div class="mb-4 flex gap-2">
                    <x-input placeholder="Kategorie" name="prices[0][category]" :data-index="$key"
                        wire:model="pricings.{{ $key }}.category" class="grow" required />
                    <x-input type="number" placeholder="0,00" name="prices[0][price]" class="mb-0" required />
                    <x-danger-button wire:click="removePricing('{{ $key }}')"
                        wire:confirm="Möchtest du die Preiskategorie wirklich löschen?" type="button">
                        <x-icon name="delete" color="white" />
                    </x-danger-button>
                </div>
            @endforeach
            <x-secondary-button wire:click="addPricing">
                <x-icon name="add" /> Preiskategorie hinzufügen
            </x-secondary-button>


        </x-body-section>

        <x-body-section title="Zutrittsberechtigungen" class="pb-4">
            @foreach ($permits as $permit)
                <div class="bg-slate-100 p-4 mb-4 rounded flex justify-between">
                    <p>{{ $permit->name }} ({{ $permit->date }})</p>
                    <x-danger-button wire:click="removePermit({{ $permit->id }})"
                        wire:confirm="Möchtest du die Zutrittsberechtigung wirklich löschen?" type="button">
                        <x-icon name="delete" color="white" />
                    </x-danger-button>
                </div>
            @endforeach
            <x-secondary-button x-on:click.prevent="$dispatch('open-modal', 'select-permit');">
                <x-icon name="add" /> Zutrittberechtigung hinzufügen
            </x-secondary-button>
        </x-body-section>
        <x-modal name="select-permit">



            <div class="p-6">
                <h2 class="mb-2 text-lg font-semibold">Veranstaltung auswählen</h2>
                <p class="mb-6">Zum Zutritt zu welcher Veranstaltung soll das Ticket berechtigen?</p>
                @forelse (App\Models\Event::where("user_id", auth()->user()->id)->get() as $event)
                    <div class="rounden mb-2 flex cursor-pointer bg-slate-100 p-2" wire:click="addPermit({{ $event }})">
                    {{ $event->name }}
                        ({{ $event->date }})</div>
                @empty
                    Keine Veranstaltungen verfügbar!
                @endforelse
            </div>

        </x-modal>

        <x-primary-button>
            Ticket erstellen
        </x-primary-button>

    </form>
</div>
