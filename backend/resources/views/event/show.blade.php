<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $event->name }}
        </h2>
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
                            {{ $event->date->format("d.m.Y") }}
                        </td>
                        <td>
                            {{ $event->time->format("H:i") }}
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