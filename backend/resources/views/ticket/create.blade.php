<x-app-layout>
    <x-slot name="header">
        <x-header heading="Neues Ticket erstellen"></x-header>
    </x-slot>
    <x-body>
        <x-body-box>
            <form action="{{ route('products.store') }}" method="post">
                @csrf
                <x-body-section title="Allgemeine Ticketoptionen">
                    <x-input label="Ticket Name" name="name" required />
                    <x-input type="number" label="Anzahl verfügbar" name="name" required />
                </x-body-section>

                
                <x-body-section title="Preiskategorien">
                    <div class="flex gap-2">
                        <x-input placeholder="Kategorie" name="prices[0][category]" class="grow" required />
                        <x-input type="number" placeholder="0,00" name="prices[0][price]" class="mb-0" required />
                        <x-secondary-button>
                            <x-icon name="add" />
                        </x-secondary-button>
                    </div>
                    
                </x-body-section>

                <x-body-section title="Zutrittsberechtigungen">

                </x-body-section>

                <x-primary-button>
                    Ticket erstellen
                </x-primary-button>

            </form>
        </x-body-box>

    </x-body>
</x-app-layout>
