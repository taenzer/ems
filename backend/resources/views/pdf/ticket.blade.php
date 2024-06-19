<div style="text-align: center;">
    <h1 style='margin: 0;'>Deine Tickets</h1>
    <p>Bitte ausgedruckt oder digital zum Event mitbringen. QR Code nicht falten!</p>
</div>
<div style="text-align: center;">
@foreach ($tickets as $ticket)
    

    <div class="ticket"
        style="
            page-break-inside: avoid; 
            font-family: 'Helvetica'; 
            position: relative; 
            display: inline-block; 
            margin: 20px 0; 
            text-align: left; 
            border: 5px solid #2b7b18; 
            height: 250px; width: 600px; 
            background-image: url(); 
            margin: 20px 0;
        ">

        <img style=" width: 100%; height: 100%; position: absolute; top: 0; left: 0;" src="{{ resource_path('img/sommerkino-ticket-bg.png') }}" alt="Hintergrund" />

        <div style="position: absolute; right: 0; top: 50%; transform: translate(-60px, -50%);">
            <img style="height: 100px; width: 100px; " src="data:image/png;base64,{!! base64_encode(QrCode::format("png")->size(100)->backgroundColor(255, 255, 255, 0)->generate($ticket->id."#".$ticket->secret)) !!}" alt="QR Code" />

            <p style="text-align:center; line-height: 1; margin: 10px 0 0 0; font-size: 0.7em; letter-spacing: 3px;">{{ $ticket->secret }}
            </p>
        </div>

        <div
            style="position: relative; z-index: 10; line-height: 1; margin-left: 45px; margin-top: 55px; width: 360px; page-break-before: avoid; page-break-after: avoid;">
            <img style="display: inline-block; page-break-before: avoid; page-break-after: avoid; height: 60px; margin: 0 0 0 -7px;" src="{{ resource_path('img/logo-sommerkino.png') }}" alt="Logo Sommerkino" />
            <img style="display: inline-block; page-break-before: avoid; page-break-after: avoid; height: 50px; margin: 0 0 0 5px;" src="{{ resource_path('img/logo-ahg.png') }}" alt="Logo AHG" />
            <h3
                style="font-size:1.3em; page-break-before: avoid; page-break-after: avoid; padding: 0 0 5px 0; margin: 0 0 5px 0;  border-bottom: 1px solid black; display: inline-block;">
                AHG SOMMERKINO TICKET #{{ $ticket->id }}</h3>
            <p style="page-break-before: avoid; page-break-after: avoid; margin: 5px 0; ">{{ $ticket->ticketProduct->name }} - {{ $ticket->ticketPrice->category }} (@money($ticket->ticketPrice->price))</p>
            <p style="page-break-before: avoid; page-break-after: avoid; margin: 5px 0; ">Gültig für: 
            @foreach ($ticket->ticketProduct->permittedEvents as $event)
                {{ $event->name }} ({{ $event->dateString() }}){{ $loop->last ? '' : ', ' }}
            @endforeach
            
            </p>

        </div>
        
        <img style=" width: 60px; position: absolute; bottom: 0px; right: 0px;" src="{{ resource_path('img/logo-eventverein.png') }}" alt="Logo Eventverein" /> 
    </div>
@endforeach
</div>

<p style="font-size: 0.7em; text-align: center; opacity: 0.8;">&copy; EMS Event-Management-System von TNZ Dienstleistungen, lizenziert für Evenverein Tambach-Dietharz e.V.</p>

