<x-app-layout>
    <x-slot name="header">
        <x-header heading="Geräte verwalten"></x-header>
    </x-slot>
    <x-body>
        <x-body-box>
            <div class="flex justify-between items-start">
                <h3 class="font-semibold mb-6">Geräteübersicht</h3>
                <x-secondary-button x-data="{}" x-on:click.prevent="$dispatch('open-modal', 'new-api-token');">Neuer API Token</x-secondary-button>
            </div>

            <x-modal name="new-api-token" >
                <div class="p-8">
                    <livewire:a-p-i-token-generator />
                </div>
            </x-modal>
            
            
            <table class="w-full border-collapse rounded-lg overflow-hidden border-solid border-2 border-b-0 border-slate-100">
                <thead class="font-semibold bg-slate-100">
                    <tr>
                        <td class="py-2 px-4">Geräte ID</td>
                        <td class="py-2 px-4">Name</td>
                        <td class="py-2 px-4">Zuletzt verwendet</td>
                        <td class="py-2 px-4">Erstellt</td>
                        <td class="py-2 px-4">Löschen</td>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($user->tokens as $token)
                    <tr>
                        <td class="py-2 px-4 border-b-2 border-solid border-slate-100 bg-slate-50">{{ $token->id }}</td>
                        <td class="py-2 px-4 border-b-2 border-solid border-slate-100 bg-slate-50">{{ $token->name }}</td>
                        <td class="py-2 px-4 border-b-2 border-solid border-slate-100 bg-slate-50">{{ $token->last_used_at?->format("d.m.Y H:i") ?? "-" }}</td>
                        <td class="py-2 px-4 border-b-2 border-solid border-slate-100 bg-slate-50">{{ $token->created_at?->format("d.m.Y H:i") ?? "-" }}</td>
                        <td class="py-2 px-4 border-b-2 border-solid border-slate-100 bg-slate-50">
                            <form action="{{ route("profile.devices.destroy") }}" method="POST">
                                @csrf 
                                @method("DELETE")
                                <input type="hidden" name="device_id" value="{{ $token->id }}">
                                <x-danger-button>
                                    <x-misc.icon name="delete" color="white"></x-misc.icon>
                                </x-danger-button>
                                
                            </form>

                        </td>
                    </tr>
                    @empty
                        <tr><td colspan="5" class="italic text-center p-4 bg-slate-50">Es wurden noch keine Geräte vernüpft</td></tr>
                    @endforelse
                </tbody>
            </table>
        </x-body-box>
    </x-body>
</x-app-layout>
