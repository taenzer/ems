@props(['link'])

    <a href="{{$link}}">
        <x-secondary-button>
            <span>{{$slot}}</span>
        </x-secondary-button>
   
    </a>
