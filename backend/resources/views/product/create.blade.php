<x-app-layout>
    <x-slot name="header">
        <x-header heading="Neues Event erstellen"></x-header>
    </x-slot>
    <x-body>
        <x-body-box>
            <form action="{{ route("event.store") }}" method="post">
                @csrf
                <x-input 
                name="name" 
                label="Name der Veranstaltung"
                />
                <x-input 
                name="date" 
                label="Datum"
                type="date"
                />
                <x-input 
                name="time" 
                label="Uhrzeit"
                type="time"
                />
                <x-primary-button>Speichern</x-primary-button>

            </form>
        </x-body-box>
       
    </x-body>
</x-app-layout>

