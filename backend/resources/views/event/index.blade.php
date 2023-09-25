<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Events
        </h2>
    </x-slot>

    <x-body>
        @foreach ($events as $event)
        <x-body-box>
            <div
            class="grid-rows-2 gap-x-2"
            style="display: grid;
                    grid-template-columns: 1fr auto auto; align-items: center;" >
                <a href="{{ route('event.show', ['event' => $event])}}" style="grid-area: 1 1 1 1;" class="font-semibold">
                {{ $event->name }}
                </a>
                <span style="grid-area: 2 / 1 / 2 / 1" class="text-xs">{{ $event->date->format("d.m.Y") }} {{ $event->time->format("H:i") }}</span>
                <span style="grid-area: 1 / 2 / 3 / 3">ACt</span>
                <span style="grid-area: 1 / 3 / 3 / 4">  <a href="{{ route('event.show', ['event' => $event])}}"><x-icon name="chevron-right"/></a> </span>
            </div>
            
        </x-body-box>
        @endforeach
        
    </x-body>

    
</x-app-layout>