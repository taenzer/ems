@props(["gateway", "member_name" => null])
@php
$globalClasses = "text-xs font-medium inline-flex items-center px-1.5 py-0.5 rounded me-2 border gap-1 uppercase";
if(isset($member_name) && mb_strlen($member_name) > 7){
    $member_name = mb_substr($member_name, 0, 7) . "...";
}

@endphp

@switch(strtolower($gateway))
    @case('member')
        <span class="bg-blue-100 text-blue-800  dark:bg-blue-900 dark:text-blue-300 border-blue-400 {{ $globalClasses }}">
            <x-misc.icon name="person" color="#1e40af"/>
            {{ isset($member_name) ? $member_name : "Helfer" }}
        </span>
        @break
    @case('bar')
        <span class="bg-green-100 text-green-800  dark:bg-gray-700 dark:text-green-400 border border-green-400 {{ $globalClasses }}">
            <x-misc.icon name="payments" color="#166534" />
            Bar
        </span>
        @break

    @case('card')
        <span class="bg-purple-100 text-purple-800  dark:bg-gray-700 dark:text-purple-400 border border-purple-400 {{ $globalClasses }}">
            <x-misc.icon name="credit-card" color="#6b21a8"/>
            Karte
        </span>
        @break

@endswitch
