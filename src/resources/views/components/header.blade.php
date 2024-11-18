@props(['heading'])

<div class="flex justify-between items-center">
    <div class="flex items-center gap-x-2">
        <!-- Before Heading -->
        @if (isset($beforeHeading))
        <div>
            {{ $beforeHeading }}
        </div>
        @endif
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-none align-top">
            {{ $heading }}
        </h2>
        <!-- After Heading -->
        @if (isset($afterHeading))
        <div>
            {{ $afterHeading }}
        </div>
        @endif
    </div>


<!-- Header Actions -->
@if (isset($actions))
<div class="flex items-center justify-end gap-2">
    {{ $actions }}
</div>
    
@endif

</div>


