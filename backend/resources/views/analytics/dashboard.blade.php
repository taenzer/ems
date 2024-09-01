<x-app-layout>
    <x-slot name="header">
        <x-header heading="EMS Analytics">
        </x-header>
    </x-slot>
    <x-body>
        <a href="{{ route('analytics.eventProductSales') }}">Event Product Sales</a>
    </x-body>
</x-app-layout>
