<x-app-layout>
    <x-slot name="header">
        <x-header heading="Event bearbeiten: {{ $event->name }}"></x-header>
    </x-slot>
    <x-body>
        <x-body-box>
            <form action="{{ route("events.update", ["event" => $event]) }}" method="post">
                @csrf
                @method("PATCH")

                <x-input 
                name="name" 
                label="Name der Veranstaltung"
                value="{{ $event->name }}"
                />
                <x-input 
                name="date" 
                label="Datum"
                type="date"
                value="{{ $event->date }}"
                />
                <x-input 
                name="time" 
                label="Uhrzeit"
                type="time"
                value="{{ $event->time }}"
                />
                <x-primary-button>Speichern</x-primary-button>

            </form>
        </x-body-box>
       
    </x-body>
</x-app-layout>

