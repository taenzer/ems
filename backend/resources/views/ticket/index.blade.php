<x-app-layout>
    <x-slot name="header">
        <x-header heading="Tickets">
            <x-slot name="actions">
                <a href="{{ route('tickets.orders.index') }}"><x-primary-button>Ticket verkaufen</x-primary-button></a>
                <a href="{{ route('tickets.products.index') }}"><x-secondary-button>Ticket Produkte
                        verwalten</x-secondary-button></a>
            </x-slot>
        </x-header>
    </x-slot>
    <x-body>
        <x-body-box>
            Work in Progress!
        </x-body-box>


        <x-body-box>
            <h3 class="mb-2 font-semibold">Verkaufte Tickets</h3>
            <div class="flex flex-col gap-2">
                @forelse($events as $event)
                    <div class="flex items-center justify-between rounded bg-slate-100 p-4">
                        <p><strong class="font-semibold">{{ $event->name }}</strong> <br> {{ $event->dateString() }}</p>
                        <p>{{ $event->tickets->count() }}</p>
                    </div>
                @empty
                @endforelse
            </div>

        </x-body-box>

        <x-body-box>
            <livewire:livewire-column-chart {{-- key="{{ $columnChartModel->reactiveKey() }}" --}} :column-chart-model="$columnChartModel" />
            <livewire:livewire-line-chart style="height: 300px" {{-- key="{{ $columnChartModel->reactiveKey() }}" --}} :line-chart-model="$salesChartModel" />
        </x-body-box>

    </x-body>
</x-app-layout>
