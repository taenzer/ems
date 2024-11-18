<x-app-layout>
    <x-slot name="header">
        <x-header heading="Events">
            <x-slot name="actions">
                <a href="{{ route('events.create') }}"><x-primary-button>Neues Event</x-primary-button></a>
            </x-slot>
        </x-header>
        
    </x-slot>

    <x-body>
        @foreach ($events as $event)
        <x-body-box>
            <div
            class="grid-rows-2 gap-x-2"
            style="display: grid;
                    grid-template-columns: 1fr auto auto; align-items: center;" >
                <a href="{{ route('events.show', ['event' => $event])}}" style="grid-area: 1 1 1 1;" class="font-semibold">
                {{ $event->name }}
                </a>
                <span style="grid-area: 2 / 1 / 2 / 1" class="text-xs">{{ $event->dateString() }} {{ $event->timeString() }}</span>
                <span style="grid-area: 1 / 2 / 3 / 3"><x-event-active :active="$event->active"/></span>
                <span style="grid-area: 1 / 3 / 3 / 4">  <a href="{{ route('events.show', ['event' => $event])}}"><x-icon name="chevron-right"/></a> </span>
            </div>
            
        </x-body-box>
        @endforeach
        
    </x-body>

    
</x-app-layout>