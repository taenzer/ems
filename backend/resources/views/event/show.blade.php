<x-app-layout>
    <x-slot name="header">
        <x-header heading="{{ $event->name }}">
            <x-slot name="beforeHeading">
                <a href="{{ route('events.index') }}" class="opacity-50">
                    <x-icon name="chevron-left" />
                </a>
            </x-slot>
            <x-slot name="afterHeading">
                <x-event-active :active="$event->active" />
            </x-slot>
            <x-slot name="actions">
                <a href="{{ route('events.edit', ['event' => $event]) }}">
                    <x-primary-button>Bearbeiten</x-primary-button>
                </a>
                <x-secondary-button>{{ $event->active ? 'Deaktivieren' : 'Aktivieren' }}</x-secondary-button>
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
            <h3 class="mb-2 font-semibold">Tickets</h3>
            <x-link-button link="/events/{{ $event->id }}/add/tickets">Tickets hinzufügen</x-link-button>
        </x-body-box>
        <x-body-box>
            <h3 class="mb-2 font-semibold">Produkte</h3>

            @if ($product_sets->isNotEmpty())

                <form action="{{ route('events.products.update', ['event' => $event]) }}" method="POST"
                    x-ref="form.events.products">
                    <div class="flex gap-4 mb-6">
                        @csrf
                        @method('PATCH')
                        @foreach ($product_sets as $type => $prods)
                            <x-body-section title="{{ \App\Models\Product::getTypes()[$type] }}" class="basis-2/4 grow">

                                <x-sortable class="flex flex-col gap-2" handle=".handle" x-data="{ count: 0, childs: Array.from($refs.wrap.children) }"
                                    x-on:prio-changed=" childs = Array.from($el.children); count++;" x-ref="wrap">
                                    @foreach ($prods as $product)
                                        <div class="flex bg-slate-100 rounded py-2 px-4 items-center justify-between"
                                            x-data="{ prio: childs.length - childs.indexOf($el) }" x-init="$watch('count', function(value) { prio = childs.length - childs.indexOf($el) })">
                                            <div class="flex gap-2 items-center">
                                                <span class="handle cursor-move"><x-icon name="drag-indicator" /></span>
                                                <span>{{ $product->name }}</span>
                                            </div>

                                            <p x-text="prio"></p>
                                            <div class="flex items-center gap-2">
                                                <x-input.auto-width name="products[{{ $product->id }}][price]"
                                                    before="Preis:" after="€"
                                                    value="{{ $product->product_data->price }}" required min="-9999"
                                                    max="9999" inputmode="numeric" />
                                                <span x-data="{}"
                                                    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion'); $dispatch('select-link-to-delete', {product_id: {{ $product->id }}})"><x-icon
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
                            <h2 class="font-semibold mb-2 text-lg">Möchtest du die Verknüpfung wirklich löschen?</h2>
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
                <div class="flex flex-col justify-center items-center p-6 gap-2 bg-slate-50">
                    <p>Es wurden noch keine Produkte hinzugefügt</p>
                    <x-link-button :link="route('events.products.add', $event)">Produkte hinzufügen</x-link-button>
                </div>

            @endif

        </x-body-box>

    </x-body>


</x-app-layout>
