@props(['active' => false])

@if($active)
<span class="bg-green-200 text-green-700 rounded-full px-3 cursor-default font-semibold" style="padding-top: 0.05rem; padding-bottom: 0.05rem; ">
    Aktiv
</span>
@else 
<span class="bg-gray-200 text-gray-500 rounded-full px-3 cursor-default font-semibold ">
    Inaktiv
</span>
@endif