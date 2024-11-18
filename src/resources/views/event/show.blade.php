<x-app-layout>
    <x-slot name="header">
        <x-header heading="{{ $event->name }}">
            <x-slot name="beforeHeading">
                <a href="{{ route('events.index') }}" class="opacity-50">
                    <x-misc.icon name="chevron-left" />
                </a>
            </x-slot>
            <x-slot name="afterHeading">
                <x-event-active :active="$event->active" />
            </x-slot>
            <x-slot name="actions">
                <a href="{{ route('events.edit', ['event' => $event]) }}">
                    <x-primary-button>Bearbeiten</x-primary-button>
                </a>
                <form action="{{ route('events.status.toggle', ['event' => $event]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <x-secondary-button
                        type="submit">{{ $event->active ? 'Deaktivieren' : 'Aktivieren' }}</x-secondary-button>
                </form>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <x-secondary-button><x-misc.icon name="more"></x-misc.icon></x-secondary-button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link href="{{ route('events.shares.index', ['event' => $event]) }}">
                            Freigabe verwalten
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>
            </x-slot>
        </x-header>
    </x-slot>

    <x-body>
        <x-body-box>
            <h3 class="font-semibold">Veranstaltungsdaten</h3>
            <table>
                <thead>
                    <tr>
                        <td>Datum</td>
                        <td>Uhrzeit</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            {{ $event->dateString() }}
                        </td>
                        <td>
                            {{ $event->timeString() }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </x-body-box>
        <x-body-box>
            <div class="mb-4 flex items-center justify-between">
                <h3 class="mb-2 font-semibold">Tickets</h3>
                <x-secondary-button x-data="{}"
                    x-on:click.prevent="$dispatch('open-modal', 'generate-report');">Bericht</x-secondary-button>
            </div>
            <div class="flex flex-col gap-2">
            @forelse($ticketProducts as $ticketProduct)
                <div class="bg-slate-100 rounded p-4 flex items-center justify-between">
                <div>
                    <p class="font-semibold">{{ $ticketProduct->name }}</p>
                    <x-badge class="bg-slate-200">{{ $ticketProduct->prices()->count() }} Preiskategorien</x-badge>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('tickets.orders.create', ['event' => $event]) }}"><x-misc.icon name="shopping-cart" size="1.3"></x-misc.icon></a>
                    <a href="{{ route('tickets.event.analytics', ['event' => $event]) }}"><x-misc.icon name="analytics" size="1.3"></x-misc.icon></a>
                    <a href="{{ route('tickets.products.show', ['product' => $ticketProduct]) }}" title="Ticketdetails verwalten"><x-misc.icon name="settings" size="1.3"></x-misc.icon></a>
                    
                </div>
                    
                </div>
            @empty
                <div class="flex flex-col items-center justify-center gap-2 bg-slate-100 p-6">
                    <p>Es existieren keine Tickets die den Zugang zu diesem Event ermöglichen</p>
                    <x-link-button :link="route('tickets.products.index')">Ticket Produkte verwalten</x-link-button>
                </div>
            @endforelse
            </div>
        </x-body-box>
        <x-body-box>
            <div class="mb-4 flex items-center justify-between">
                <h3 class="mb-2 font-semibold">Produkte</h3>
                <x-link-button :link="route('events.products.settings', ['event' => $event])"><x-misc.icon name="tune"/></x-link-button>
            </div>

            @if ($product_sets->isNotEmpty())

                <form action="{{ route('events.products.update', ['event' => $event]) }}" method="POST"
                    x-ref="form.events.products">
                    <div class="mb-6 flex gap-4">
                        @csrf
                        @method('PATCH')
                        @foreach ($product_sets as $type => $prods)
                            <x-body-section title="{{ \App\Models\Product::getTypes()[$type] }}" class="grow basis-2/4">

                                <x-sortable class="flex flex-col gap-2" handle=".handle" x-data="{ count: 0, childs: Array.from($refs.wrap.children) }"
                                    x-on:prio-changed=" childs = Array.from($el.children); count++;" x-ref="wrap">
                                    @foreach ($prods as $product)
                                        <div class="flex items-center justify-between rounded bg-slate-100 px-4 py-2"
                                            x-data="{ prio: childs.length - childs.indexOf($el) }" x-init="$watch('count', function(value) { prio = childs.length - childs.indexOf($el) })">
                                            <div class="flex items-center gap-2">
                                                <span class="handle cursor-move"><x-misc.icon name="drag-indicator" /></span>
                                                <span>{{ $product->name }}</span>
                                            </div>

                                            <div class="flex items-center gap-2">
                                                <x-input.auto-width name="products[{{ $product->id }}][price]"
                                                    before="Preis:" after="€"
                                                    value="{{ $product->product_data->price }}" required min="-9999"
                                                    max="9999" inputmode="numeric" />
                                                <span x-data="{}"
                                                    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion'); $dispatch('select-link-to-delete', {product_id: {{ $product->id }}})"><x-misc.icon
                                                        name="link-off" color="red" size="1" /></span>
                                            </div>
                                            <input type="hidden" name="products[{{ $product->id }}][prio]"
                                                x-model="prio">
                                            <input type="hidden" name="products[{{ $product->id }}][product_id]"
                                                value="{{ $product->id }}">
                                        </div>
                                    @endforeach

                                </x-sortable>




                            </x-body-section>
                        @endforeach

                    </div>

                    <x-primary-button>Änderungen Speichern</x-primary-button>
                    <a href="{{ route('events.products.add', $event) }}">
                        <x-secondary-button>Neue Produkte hinzufügen</x-secondary-button>
                    </a>

                </form>
                <x-modal name="confirm-user-deletion">

                    <form action="{{ route('events.products.destroy', ['event' => $event]) }}" method="POST"
                        x-data="{ selected_product: null }"
                        x-on:select-link-to-delete.window="selected_product = $event.detail.product_id;">
                        @csrf
                        @method('DELETE')

                        <div class="p-6">
                            <h2 class="mb-2 text-lg font-semibold">Möchtest du die Verknüpfung wirklich löschen?</h2>
                            <p class="mb-6">Das Produkt an sich sowie die Verkaufsstatistik werden dadurch nicht
                                gelöscht.</p>
                            <x-select name="product_id" label="Ausgewähltes Produkt" x-model="selected_product">
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach

                            </x-select>
                            <x-danger-button>Verknüpfung löschen</x-danger-button>
                            <x-secondary-button x-on:click="$dispatch('close')">Abbrechen</x-secondary-button>
                        </div>


                    </form>
                </x-modal>
            @else
                <div class="flex flex-col items-center justify-center gap-2 bg-slate-100 p-6">
                    <p>Es wurden noch keine Produkte hinzugefügt</p>
                    <x-link-button :link="route('events.products.add', $event)">Produkte hinzufügen</x-link-button>
                </div>

            @endif

        </x-body-box>

        <x-body-box>
            <div class=" flex items-center justify-between">
                <h3 class="font-semibold">Verkaufsstatistik</h3>
                <div class="flex items-center gap-2">
                    <x-secondary-button x-data="{}"
                        x-on:click.prevent="$dispatch('open-modal', 'generate-report');">Bericht</x-secondary-button>
                    <a href="{{ route('events.orders.protocoll', $event) }}" title="Verkaufsprotokoll">
                        <x-secondary-button x-data="{}"><x-misc.icon name="receipt-long" size="1"/></x-secondary-button>
                    </a>
                </div>

            </div>


            @if ($orderStatsByGateway->isNotEmpty())
                <livewire:order-stats-display :orderStatsByGateway="$orderStatsByGateway"/>
            @else
                <div class="flex flex-col items-center justify-center gap-2 bg-slate-100 p-6">
                    <p>Es wurden noch keine Produkte verkauft</p>
                </div>

            @endif
            <x-modal name="generate-report">
                <div class="p-6">
                    <livewire:event-report-generation-form :event="$event"/>
                </div>

            </x-modal>
        </x-body-box>

    </x-body>


</x-app-layout>
