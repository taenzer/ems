@props(['chartId' => 'chart', 'class' => '', 'ticketSalesPerEvent'])
@php
    $colors = collect(['#ee6352', '#59cd90', '#3fa7d6', '#fac05e', '#f79d84', '#ba7ba1', '#855fa8', '#4d3b8e']);
    $colors = $colors->shuffle()->all();
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
                type: "bar",
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
                data: @json($ticketSalesPerEvent->values())
            }],

            xaxis: {
                categories: @json($ticketSalesPerEvent->keys())
            },
            plotOptions: {
                bar: {
                    columnWidth: "80%",
                    distributed: true,
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
                show: false,
            }
        };

        var chart = new ApexCharts(document.querySelector("#{{ $chartId }}"), options);
        chart.render();
    </script>
@endpush
