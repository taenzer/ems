@props(['chartId' => 'chart', 'class' => '', 'ticketSalesPerDay'])
@php
    $colors = collect(['#ee6352', '#59cd90', '#3fa7d6', '#fac05e', '#f79d84', '#ba7ba1', '#855fa8', '#4d3b8e']);
    $colors = $colors->shuffle();
@endphp
<div class="relative mb-4">
    <div id="{{ $chartId }}">
    </div>
</div>

@push('custom-js')
    <script>
        var options = {
            chart: {
                height: 350,
                type: "area",
                zoom: {
                    enabled: false
                },
            },
            dataLabels: {
                enabled: true
            },
            colors: @json($colors),
            series: [{
                name: "Ticketverkäufe",
                data: @json($ticketSalesPerDay->values())
            }],

            stroke: {
                width: 5,
                curve: "smooth"
            },
            xaxis: {
                type: 'datetime',
                formatter: function(value, timestamp) {
                    return new Date(timestamp).toLocaleDateString();
                },
                categories: @json($ticketSalesPerDay->keys())
            },
            plotOptions: {
                bar: {
                    columnWidth: "20%"
                }
            },
            tooltip: {
                enabled: true,
                x: {
                    show: true
                },
                marker: {
                    show: false
                }
            },
            legend: {
                horizontalAlign: "left",
                offsetX: 40
            }
        };

        var chart = new ApexCharts(document.querySelector("#{{ $chartId }}"), options);
        chart.render();
    </script>
@endpush
