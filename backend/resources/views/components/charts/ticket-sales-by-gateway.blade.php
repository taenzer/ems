@props(['chartId' => 'chart', 'class' => '', 'ticketSalesPerGateway'])
@php
    $colors = collect(['#ee6352', '#59cd90', '#3fa7d6', '#fac05e', '#f79d84', '#ba7ba1', '#855fa8', '#4d3b8e']);
    $colors = $colors->shuffle()->all();
@endphp
<div class="relative mb-4 flex justify-center">
    <div id="{{ $chartId }}">
    </div>
</div>

@push('custom-js')
    <script>
        var options = {
            colors: @json($colors),
            series: @json($ticketSalesPerGateway->values()),
            chart: {
                width: 500,
                type: 'pie',
                colors: @json($colors),
            },
            fill: {
                colors: @json($colors),}
            ,
            labels: @json($ticketSalesPerGateway->keys()),
            legend: {
                // Show the legend
                show: true,
                markers: {
                // Set the legend colors as the ones passed in
                fillColors: @json($colors)
                }
            },
        };

        var chart = new ApexCharts(document.querySelector("#{{ $chartId }}"), options);
        chart.render();
    </script>
@endpush
