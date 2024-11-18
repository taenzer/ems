<div>
    <h3 class="font-semibold mb-6">Neuer API Token</h3>
    @if($token == "")
        <x-input type="text" name="token-name" wire:model="tokenName" placeholder="Token Name" hint="Legen sie einen Name für den API Token fest, durch den die Anwendung klar erkennbar ist!"/>
        <x-primary-button wire:click="generateToken">API Token erstellen</x-primary-button>
    @else
    <div class="flex justify-between gap-2">
        <x-input type="text" class="grow" name="generated-token" wire:model="tokenOutput" readonly/>
        <x-primary-button wire:click="toggleVisibility"><x-misc.icon color="white" :name="$isVisible ? 'visibility-off' : 'visibility'" /></x-primary-button>
        </div>
        <p class="mt-2 italic text-gray-400">Kopieren und speichern sie den Token sicher! Nachdem sie das Fenster geschlossen haben, können Sie ihn nicht mehr anzeigen lassen!</p>
    @endif
    
</div>
