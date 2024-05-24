<x-app-layout>
    <x-slot name="header">
        <x-header heading="Freigaben verwalten: {{ $event->name }}"></x-header>
    </x-slot>
    <x-body>

        <x-body-box>
            <h3 class="font-semibold">Neue Freigabe</h3>
            <p>Gib dieses Event für ein anderes Konto frei.</p>
            <form action="{{ route('events.shares.store', ['event' => $event]) }}" method="POST" class="mt-4">
                @csrf
                <x-input name="email" placeholder="Email Adresse" />
                <x-select name="permission">
                    <option value="view">Anzeigen</option>
                    <option value="edit" disabled>Bearbeiten</option>
                </x-select>
                <x-primary-button>Freigabe erteilen</x-primary-button>
            </form>
        </x-body-box>
        <x-body-box>
            <h3 class="font-semibold">Bestehende Freigaben</h3>
            @if($shares->isEmpty())
                <x-notification type="info" class="mt-4">
                    Diese Veranstaltung wurde mit noch niemandem geteilt!
                </x-notification>
            @else
            <div class="flex flex-col gap-2 mt-4">
                @foreach ($shares as $share)
                    <div class="flex items-center justify-between rounded bg-slate-100 p-4">
                        <p>{{ $share->sharedTo->name }} - {{ $share->permission }}</p>
                        <form action="{{ route('events.shares.destroy', ['share' => $share, 'event' => $event]) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <x-danger-button type="submit">Löschen</x-danger-button>
                        </form>
                    </div>
                @endforeach
            </div>
            @endif

        </x-body-box>
    </x-body>
</x-app-layout>
