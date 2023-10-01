@props(['type' => 'info'])

<div {{ $attributes->merge(["class" => "flex justify-between bg-yellow-200 p-4 rounded gap-4 items-center"]) }}>

    <div class="flex items-center gap-2">
        <span><x-icon name="emergency-home"/></span>
        <span>{{ $slot }}</span>
    </div>
    @isset($actions)
        <div>
            {{ $actions }}
        </div>
    @endisset
    
</div>