
<div class="vinfo">
    <h1>Verkaufsbericht Tickets</h1>
    <p><strong>Veranstaltung:</strong> {{ $event->name }} ({{ $event->datestring() }})</p>
    <p><strong>Gateways:</strong> <span class="uppercase">{{ implode(', ', $gateways) }}</span></p>
</div>

<table class="stats">
<thead>
<tr>
<th style="text-align: left;">Ticket</th>
<th>Verkäufe<br>
<table class="priceTable"><tr><td>Anz.</td><td>Preis</td></tr></table>
</th>
<th class="right">Umsatz</th>
</tr>

</thead>
<tbody>
@foreach ($ticketSaleStats as $ticket => $ticketPrices)
    <tr>
        <td style="width: 50%;">{{ $ticket }}</td>
        <td class="prices">
            <table class="priceTable">
                @foreach ($ticketPrices as $priceData)
                    <tr>
                        <td>{{ $priceData["count"] }}</td>
                        <td>@money($priceData["price"] + $priceData["fee"])</td>
                    </tr>
                @endforeach
            </table>
        </td>
        <td class="right">@money($ticketPrices->sum("sum"))</td>
    </tr>
@endforeach
</tbody>
</table>


<div class="item summary-wrp">
<table class="summary">

    <tr>
        <td rowspan="2" style="vertical-align: center;"><span class="total">Zusammenfassung</span><br><span class="stattitle">Gateways: {{ implode(', ', $gateways) }}</span></td>
        <td class="stattitle">Verkaufte Tickets</td>
        <td class="stattitle">Summe Umsatz</td>
    </tr>

    <tr>   
        <td class="total">{{ $ticketSaleStats->map(function($ticketPrices){ return $ticketPrices->sum("count"); })->sum() }}</td>
        <td class="total">@money($ticketSaleStats->map(function($ticketPrices){ return $ticketPrices->sum("sum"); })->sum())</td>
    </tr>

</table>
</div>


<p class="stattitle gray" style="margin-top: 10px;">Bericht generiert am {{ date("d.m.Y H:i:s") }} Uhr vom Event Management System.</p>
<p class="stattitle gray">Fingerprint: {{ hash("md5", $ticketSaleStats) }}</p>



<style>
    .stats > tbody > tr > td, .stats th{
        border: 1px solid;
    }

    .stats td{
        padding: 3px 10px;
    }

    .stats .prices{
        padding: 0;
    }

    .stats th{
        padding: 3px 10px;
        background: #efefef;
    }

    .stats td.prices{
        width: 25%;
    }

    .stats{
        margin-bottom: 20px;
    }
    
    .stats tbody  > tr:nth-child(even){
        background: #efefef;
    }


    .priceTable{
        table-layout: fixed;
    }
    .priceTable td{
        padding: 3px 10px;
    }
    .priceTable td:first-child{
        border-right: 1px solid black;
    }
    .priceTable td:last-child{
        text-align: right;
    }

    .priceTable tr:first-child{
        border-bottom: 1px solid;
    }

    .priceTable tr:last-child {
        border-bottom: 0px;
    }

    .right{
        text-align: right;
    }

    .summary-wrp{
        background: #efefef;
        padding: 10px;
        border-radius: 3px;
    }

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


    * {
        line-height: 1;
    }

    .grow {
        width: 100%;
    }

    .shrink {
        white-space: nowrap;
    }

    .total {
        font-weight: bold;
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
    p {
        margin: 0;
    }
</style>
