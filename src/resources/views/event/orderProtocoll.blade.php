<x-app-layout>
    <x-slot name="header">
        <x-header heading="Verkaufsprotokoll: {{ $event->name }}">
            <x-slot name="beforeHeading">
                <a href="{{ route('events.show', $event) }}" class="opacity-50">
                    <x-misc.icon name="chevron-left" />
                </a>
            </x-slot>
        </x-header>
    </x-slot>
    <x-body>
        <x-body-box>
            <livewire:event-order-protocoll :event="$event" />
        </x-body-box>
    </x-body>
</x-app-layout>
