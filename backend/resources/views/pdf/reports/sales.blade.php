<table>
<thead>
    <tr>
        <td>ProduktId</td>
        <td>Produktdetails</td>
        <td>Summe Anzahl</td>
        <td>Zwischensumme</td>
    </tr>
</thead>
@foreach ($orderItems as $id => $items)
    <tr class="item">

        <td class="pId">{{ $id }}</td>
        
        <td class="datail">
            <table>
                <thead>
                    <tr>
                        <td>Bezeichnung</td>
                        <td>Preis</td>
                        <td>Anzahl</td>
                        <td>Zwischensumme</td>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($items["grouped"] as $groups) 
                        @foreach ($groups as $subitem)
                        <tr>
                            <td>{{ $subitem["name"] }}</td>
                            <td>{{ $subitem["price"] }}</td>
                            <td>{{ $subitem["quantity"] }}</td>
                            <td>{{ $subitem["itemTotal"] }}</td>
                        </tr>
                        @endforeach

                    @endforeach
                </tbody>
            </table>
        </td>
        <td>
            {{ $items["totalQuantity"]}}
        </td>
        <td>
            @money($items["totalItemTotal"])
        </td>

    </tr>
@endforeach

</table>


<style>
table{
    border-collapse: collapse;
}

table td{
    border: 1px solid;
}
</style>


