<x-app-layout>    
    <x-slot name="header">
        <x-header heading="Erweiterte Verkaufseinstellungen: {{ $event->name }}">
        </x-header>
    </x-slot>    

    <x-body>
    
        <x-body-box>
            <livewire:member-list-settings :event="$event"/>
        </x-body-box>
    
    </x-body>
</x-app-layout>