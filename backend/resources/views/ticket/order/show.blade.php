<x-app-layout>
    <x-slot name="header">
        <x-header heading="Ticketbestellung">
            <x-slot name="beforeHeading">
                <a href="{{ route('tickets.index') }}"><x-icon name="chevron-left"></x-icon></a>
            </x-slot>
        </x-header>
    </x-slot>
    <x-body>
        <x-body-box>
            <p>Hallo Welt!</p>
        </x-body-box>

    </x-body>
</x-app-layout>
