<x-app-layout>
    <x-slot name="header">
        <x-header heading="{{ $event->name }}">
            <x-slot name="beforeHeading">
                <a href="{{ route("events.index")}}" class="opacity-50">
                    <x-icon name="chevron-left"/>
                </a>
            </x-slot>
            <x-slot name="afterHeading" >
                <x-event-active :active="$event->active"/>
            </x-slot>
            <x-slot name="actions">
                <a href="{{ route('events.edit', ['event' => $event]) }}">
                    <x-primary-button>Bearbeiten</x-primary-button>
                </a>
                <x-secondary-button>{{ $event->active ? "Deaktivieren" : "Aktivieren" }}</x-secondary-button>
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
            <x-link-button link="/events/{{$event->id}}/add/tickets">Tickets hinzufügen</x-link-button>
        </x-body-box>
        <x-body-box>
            <h3 class="mb-2 font-semibold">Produkte</h3>
            <x-link-button :link="route('events.products.add', $event)">Produkte hinzufügen</x-link-button>

            <form action="{{ route("events.products.update", ["event" => $event]) }}" method="POST">
                <div class="flex gap-4">
                    @csrf
                @method("PATCH")
                @foreach ($event->products->groupBy("type") as $type => $products)
                <x-body-section title="{{\App\Models\Product::getTypes()[$type] }}" class="basis-2/4 grow">
                    <div class="flex flex-col gap-2">
                        @foreach ($products as $product)
                            
                            <div class="flex bg-slate-100 rounded py-2 px-4 items-center justify-between">
                                <div class="flex gap-2 items-center">
                                    <span><x-icon name="drag-indicator"/></span>
                                    <span>{{ $product->name }}</span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <x-input.auto-width 
                                        name="products[{{$product->id }}][price]"
                                        before="Preis:"
                                        after="€"
                                        value="{{$product->product_data->price}}"
                                        required
                                        min="-9999"
                                        max="9999"
                                        inputmode="numeric"
                                    />
                                    <span><x-icon name="link-off" color="red" size="1"/></span>
                                </div>
                                
                                <input type="hidden" name="products[{{$product->id }}][product_id]" value="{{ $product->id }}">
                            </div>

                        @endforeach
                    </div>


                </x-body-section>
                @endforeach

                </div>
                
                <x-primary-button>Speichern</x-primary-button>
            </form>
            
        </x-body-box>

    </x-body>

    
</x-app-layout>