@props(['title' => ''])
<div class="py-1">
    <div class="flex items-center justify-start gap-2 pb-4">
        <div class="font-semibold uppercase text-sm text-gray-600">{{ $title }}</div>
        <div class="flex-grow bg-gray-400" style="height: 1px"></div>

    </div>
    <div></div>
    {{ $slot }}
</div>