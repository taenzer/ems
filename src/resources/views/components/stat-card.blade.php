@props(["title", "money" => false, "main" => "", "small" => ""])

<div class="w-full max-w-sm p-3 bg-white border border-gray-200 rounded-lg shadow sm:p-6 dark:bg-gray-800 dark:border-gray-700">
    <h5 class=" font-medium text-gray-500 dark:text-gray-400">{{ $title }}</h5>
    <div class="flex items-baseline text-gray-900 dark:text-white">
        <span class="text-3xl font-extrabold tracking-tight">
            @if($money)
                @money($main)
            @else
                {{ $main }}
            @endif
        
        </span>
    </div>
    <span>{{$small}}</span>
</div>