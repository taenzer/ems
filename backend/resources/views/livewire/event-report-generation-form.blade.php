<div>
                        @csrf
                        @method('post')
                        <h2 class="mb-2 text-lg font-semibold">Veranstaltungsbericht erstellen</h2>
                        <x-select name="report-type" wire:model="reportType" wire:change="reportTypeChanged" label="Art des Berichts">
                            <option value="sales">Verkaufsbericht</option>
                            <option value="tickets">Ticketverkäufe</option>
                            <option value="ticket-checkins">Ticket-Checkins</option>
                        </x-select>
                        <x-select name="report-user" label="Verkäuferkonto" wire:model="selectedUser">
                            <option value="all">Alle</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </x-select>
                        <div class="mb-6">
                            <p class="mb-2 block text-xs font-bold uppercase text-gray-700">
                                Gateways einschließen
                            </p>
                            <div class="flex items-center gap-4">
                                @foreach ($gateways as $gw)
                                    <x-input.checkbox name="selectedGateways.{{$gw}}" wire:model.live="selectedGateways.{{$gw}}" value="{{ $gw }}"><span
                                            class="uppercase">{{ $gw }}</span></x-input.checkbox>
                                @endforeach
                            </div>
                        </div>
                        <x-primary-button wire:click="generateReport">Bericht erstellen</x-primary-button>
                        <x-secondary-button x-on:click="$dispatch('close')">Abbrechen</x-secondary-button>

</div>
