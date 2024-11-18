<div>
    <div class="flex justify-between gap-5 items-center">
        <div>
            <h2 class="font-semibold">Helferbezogene Verkäufe</h2>
            <p class="text-xs">Wenn diese Funktion aktiviert ist, wird in der EMS POS App jede Buchung mit dem Gateway "Helfer" an eine spezifische Person gebunden. Diese wird im Checkout-Prozess ausgewählt.</p>
        </div>
        <div wire:click.prevent="toggleEnabled">
            <x-input.toggle-switch :enabled="$enabled" />
        </div>
    </div>
    @if($enabled)
    <div class="flex flex-col gap-2 mt-4">
        @foreach ($list as $index => $member)
            <div class="flex gap-2" wire:key="{{ $index }}">
                <x-input name="memberName.{{ $index }}" placeholder="Name eintragen" class="w-full" wire:model.live="list.{{ $index }}" wire:change="inputChanged"/>
                <x-danger-button wire:click="removeMember({{ $index }})"><x-icon name="delete" color="white" /></x-danger-button>
            </div>
        @endforeach
       
        <x-secondary-button wire:click="addMember" class="py-3 px-3 gap-2"><x-icon name="person-add" />Weitere Person hinzufügen</x-secondary-button>
    </div>
    @endif

    @if($somethingChanged)
    <div wire:transition.origin.bottom >
     <x-primary-button wire:click="save" class="mt-4">Speichern</x-primary-button>
    </div>
    @endif

    <div>
        @if (session()->has('success_message'))
            <div wire:transition.origin.bottom class="text-green-700 flex gap-1 items-center pt-4">
                <x-icon name="check-circle" color="green"/>{{ session('success_message') }}
            </div>
        @endif
    </div>
</div>
