<x-app-layout>

<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Neuer Newsbeitrag
        </h2>
</x-slot>

<x-body>
    <x-misc.box >
        <form class="flex flex-col gap-4" action="{{ route("news.store") }}" method="post">
            @csrf
            <x-mary-input name="title" label="Titel" required/>
            <x-mary-textarea name="content" label="Inhalt" required></x-mary-textarea>
            <x-mary-checkbox label="Wichtiger Beitrag?" name="is_important"/>
            <div>
                <x-primary-button>Speichern</x-primary-button>
            </div>
        </form>
    </x-misc.box>
</x-body>
</x-app-layout>