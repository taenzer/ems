@props(['link'])
<div class="bg-gray-100 border border-gray-200 border-solid inline-flex py-1 px-3 rounded-sm">
    <a href="{{$link}}">
        <span>{{$slot}}</span>
    
    </a>
</div>