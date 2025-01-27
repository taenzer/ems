<x-app-layout>
    <x-slot name="header">
        <x-header heading="Events">
            <x-slot name="actions">
                <a href="{{ route('events.create') }}"><x-primary-button>Neues Event</x-primary-button></a>
            </x-slot>
        </x-header>
        
    </x-slot>

    <x-body>
        @forelse ($events as $event)
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
                <span style="grid-area: 1 / 3 / 3 / 4">  <a href="{{ route('events.show', ['event' => $event])}}"><x-misc.icon name="chevron-right"/></a> </span>
            </div>
            
        </x-body-box>

        @empty
        <x-body-box><p class="font-semibold">Keine Events gefunden!</p></x-body-box>
        @endforelse

        @if(!$include_archived)
            <div class="bg-gray-200 p-4 rounded">
                <p class="mb-2">
                    <small>Hinweis: Inaktive Veranstaltungen, deren Datum nicht im aktuellen Jahr liegt, werden automatisch archiviert. Um auch diese anzuzeigen, klicke auf den Button:</small>
                </p>
                <a href="{{ route('events.index', ['include_archived' => true]) }}" title="Archivierte Veranstaltungen anzeigen">
                    <x-secondary-button>Archivierte Veranstaltungen anzeigen</x-secondary-button>
                </a>
            </div>
            {{ $events->links() }}
        @else
            {{ $events->appends(['include_archived' => true])->links() }}
        @endif
        
    </x-body>

    
</x-app-layout>