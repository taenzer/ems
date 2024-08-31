<div class="grid grid-cols-{{ 1 + $events->count() }} grid-rows-{{ 1 + $products->count() }} gap-2">
    <div class="row-start-1 col-start-1">Produkte / Events</div>
    <div class="row-start-1 col-start-{{ 2 + $events->count() }}">
        <x-mary-choices-offline
        label="Single (frontend)"
        wire:model="user_searchable_offline_id"
        :options="$users"
        single
        searchable />
    </div>
    <div class="row-start-{{ 2 + $products->count() }} col-start-1">Produkt hinzufügen</div>

</div>
