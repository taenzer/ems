
<div class="vinfo">
    <h1>Verkaufsbericht</h1>
    <p><strong>Veranstaltung:</strong> {{ $event->name }} ({{ $event->datestring() }})</p>
    <p><strong>Gateways:</strong> <span class="uppercase">{{ implode(', ', $gateways) }}</span></p>
</div>


@foreach ($orderItems as $id => $items)
    <div class="item">

        <table>
            <tr>
                <td class="total grow">
                    @if (!empty($id))
                    @php
                        $prod = App\Models\Product::find($id);
                    @endphp
                        @if(isset($prod))
                            {{ $prod->name }}
                        @else
                            <em>Unbekanntes Produkt</em>
                        @endif
                    @else
                        Verschiedenes
                    @endif
                </td>
                <td class="right tableright shrink"><span class="stattitle">Summe Anzahl:</span><br><span
                        class="total">{{ $items['totalQuantity'] }}</span></td>
                <td class="right tableright border-left shrink"><span class="stattitle">Summe Umsatz:</span><br><span
                        class="total">@money($items['totalItemTotal'])</span></td>
            </tr>

        </table>
        <hr>
        <div class="datail">
            @foreach ($items['grouped'] as $groups)
                @foreach ($groups as $subitem)
                    <p class="vitem">{{ $subitem['quantity'] }}x {{ $subitem['name'] }} (je @money($subitem['price'])) =
                        @money($subitem['itemTotal'])</p>
                @endforeach
            @endforeach

        </div>
    </div>
@endforeach

<div class="item summary-wrp">
<table class="summary">

    <tr>
        <td rowspan="2"><span class="total">Zusammenfassung</span><br><span class="stattitle">Gateways: {{ implode(', ', $gateways) }}</span></td>
        <td class="stattitle">Verkaufte Produkte</td>
        <td class="stattitle">Summe Umsatz</td>
    </tr>

    <tr>   
        <td class="total">{{ $eventQty }}</td>
        <td class="total">@money($eventTotal)</td>
    </tr>

</table>
</div>

<p class="stattitle gray" style="margin-top: 10px;">Bericht generiert am {{ date("d.m.Y H:i:s") }} Uhr vom Event Management System.</p>
<p class="stattitle gray">Fingerprint: {{ hash("md5", $orderItems) }}</p>



<style>

    .summary td{
        vertical-align: top;
    }

    .gray{
        color: gray;
    }

    .vinfo {
        margin-bottom: 30px;
        max-width: 70%;
        position: relative;
    }

    .vinfo * {
        margin: 5px 0;
    }

    h1 {
        margin: 0;
        font-size: 1.5em;
        text-transform: uppercase;
    }

    .vitem {
        line-height: 1.3;
        font-style: italic;
    }

    * {
        line-height: 1;
    }

    .item {
        background: #efefef;
        padding: 20px;
        margin-bottom: 10px;
        border-radius: 5px;
        page-break-inside: avoid;
    }

    .right {
        text-align: right;
    }

    .grow {
        width: 100%;
    }

    .shrink {
        white-space: nowrap;
    }

    .tableright {
        padding: 0px 10px;
    }

    .total {
        font-weight: bold;
    }

    .border-left {
        border-left: 1px solid;
        padding: 0px 0 0px 10px;
    }

    .stattitle {
        text-transform: uppercase;
        font-size: 0.6em;

    }

    .uppercase {
        text-transform: uppercase;
    }

    table {

        width: 100%;

        border-collapse: collapse;
    }

    table td {
        padding: 0;
    }

    p {
        margin: 0;
    }
</style>
