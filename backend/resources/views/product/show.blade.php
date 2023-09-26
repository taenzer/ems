<x-app-layout>
    <x-slot name="header">
        <x-header heading="{{ $event->name }}">
            <x-slot name="beforeHeading">
                <a href="{{ route("event")}}" class="opacity-50">
                    <x-icon name="chevron-left"/>
                </a>
            </x-slot>
            <x-slot name="afterHeading" >
                <x-event-active :active="$event->active"/>
            </x-slot>
            <x-slot name="actions">
                <a href="{{ route('event.edit', ['event' => $event]) }}">
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
            <x-link-button link="/events/{{$event->id}}/add/products">Produkte hinzufügen</x-link-button>
        </x-body-box>

    </x-body>

    
</x-app-layout>