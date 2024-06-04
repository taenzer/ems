<div>
    <form wire:submit="save">
        @csrf
        <x-body-section title="Allgemeine Ticketoptionen">
            <x-input label="Ticket Name" name="name" wire:model="name" required :disabled="!$editable" />
            <x-input type="number" label="Anzahl verfügbar" name="tixAvailable" wire:model="tixAvailable" required :disabled="!$editable" />
            <x-select name="ticket_design_id" label="Ticket Design" wire:model="ticket_design_id" :disabled="!$editable">
                @forelse (App\Models\TicketDesign::all() as $design)
                    <option value="{{ $design->id }}">{{ $design->name }}</option>
                @empty
                    <option value="" disabled selected>Keine Designs verfügbar</option>
                @endforelse
            </x-select>
        </x-body-section>

        <x-body-section title="Preiskategorien" class="pb-4">
            @foreach ($pricings as $key => $pricing)
                <div class="mb-4 flex gap-2">
                    <x-input placeholder="Kategorie" name="category" :data-index="$key"
                        wire:model="pricings.{{ $key }}.category" class="grow" :disabled="!$editable" required />
                    <x-input type="number" placeholder="0,00" name="price" class="mb-0" :disabled="!$editable" wire:model="pricings.{{ $key }}.price" required />
                    @if($editable)
                        <x-danger-button wire:click="removePricing('{{ $key }}')"
                            wire:confirm="Möchtest du die Preiskategorie wirklich löschen?" type="button">
                            <x-icon name="delete" color="white" />
                        </x-danger-button>
                    @endif
                </div>
            @endforeach
            @if($editable)
                <x-secondary-button wire:click="addPricing">
                    <x-icon name="add" /> Preiskategorie hinzufügen
                </x-secondary-button>
            @endif


        </x-body-section>

        <x-body-section title="Zutrittsberechtigungen" class="pb-4">
            @foreach ($permits as $permit)
                <div class="mb-4 flex justify-between items-center rounded bg-slate-100 p-4">
                    <p>{{ $permit->name }} ({{ $permit->date }})</p>
                    @if($editable)
                        <x-danger-button wire:click="removePermit({{ $permit->id }})"
                            wire:confirm="Möchtest du die Zutrittsberechtigung wirklich löschen?" type="button">
                            <x-icon name="delete" color="white" />
                        </x-danger-button>
                    @endif
                </div>
            @endforeach

            @if($editable)
            <x-secondary-button x-on:click.prevent="$dispatch('open-modal', 'select-permit');">
                <x-icon name="add" /> Zutrittberechtigung hinzufügen
            </x-secondary-button>
            @endif

            <x-modal name="select-permit">
                <div class="p-6">
                    <h2 class="mb-2 text-lg font-semibold">Veranstaltung auswählen</h2>
                    <p class="mb-6">Zum Zutritt zu welcher Veranstaltung soll das Ticket berechtigen?</p>
                    @forelse (App\Models\Event::where("user_id", auth()->user()->id)->get() as $event)
                        <div class="rounden mb-2 flex cursor-pointer bg-slate-100 p-2"
                            wire:click="addPermit({{ $event }})" @click="$dispatch('close')">
                            {{ $event->name }}
                            ({{ $event->date }})
                        </div>
                    @empty
                        Keine Veranstaltungen verfügbar!
                    @endforelse
                    <x-secondary-button x-on:click="$dispatch('close')" class="mt-4">Abbrechen</x-secondary-button>
                </div>
            </x-modal>

        </x-body-section>

        @if($editable)
            <x-primary-button>
                @if($exists)
                    Ticket aktualisieren
                @else
                    Ticket erstellen
                @endif
            </x-primary-button>
        @endif

    </form>

</div>
