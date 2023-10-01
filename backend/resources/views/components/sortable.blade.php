@props(['handle'])

@php
    $uid = uniqid();
@endphp
<x-script.sortable/>

<div id="sortable-{{$uid}}" {{ $attributes }}>
    {{ $slot }}
</div>

<script>
    var sort = Sortable.create(document.getElementById("sortable-{{ $uid }}"), {
        handle: @js($handle ?? null),
        onEnd: function(evt){
            evt.item.parentElement.dispatchEvent(new CustomEvent("prio-changed", {detail: {prio: evt.newIndex}}))
        }
    });

</script>