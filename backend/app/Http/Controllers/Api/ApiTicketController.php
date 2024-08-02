<?php

namespace App\Http\Controllers\Api;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TicketOrder;
use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;

class ApiTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function createOrder(Request $request)
    {
        $attributes = $request->validate([
            "gateway" => "required|string",
            "total" => "required|numeric",
            "meta" => "nullable|array",
            "checkin" => "nullable|boolean",
            "tickets" => "required|array",
            "tickets.*.quantity" => "required|integer",
            "tickets.*.ticket_product_id" => "required|integer|exists:ticket_products,id",
            "tickets.*.ticket_price_id" => "required|integer|exists:ticket_prices,id",
        ]);

        $order = new TicketOrder();
        $order->gateway = $attributes["gateway"];
        $order->total = $attributes["total"];
        // TODO: Check if meta is not empty
        $order->meta = json_encode($attributes["meta"]);
        $order->user_id = auth()->user()->id;
        $order->save();

        $tickets = collect();
        foreach ($attributes["tickets"] as $ticket_data) {
            $qty = $ticket_data["quantity"];
            for ($i = 0; $i < $qty; $i++) {
                $tickets->push($order->tickets()->create([
                    "ticket_product_id" => $ticket_data["ticket_product_id"],
                    "ticket_price_id" => $ticket_data["ticket_price_id"],
                    "secret" => Ticket::generateSecret(),
                ])->id);

                // TODO: Check in if $attributes["checkin"] is true
            }
        }

        return response()->json($tickets, 200);
    }

    public function getTicketPdf(Request $request)
    {
        $attributes = $request->validate([
            "ticket_ids" => "required|array",
            "ticket_ids.*" => "required|integer|exists:tickets,id",
        ]);


        $tickets = Ticket::whereIn("id", $attributes["ticket_ids"])->with(["ticketOrder", "ticketPrice", "ticketProduct"])->get();
        $pdf = Pdf::loadView('pdf.ticket', array("tickets" => $tickets));
        return $pdf->download("report.pdf");
    }

    public function checkIn(Ticket $ticket, Event $event, Request $request)
    {
        $request->validate([
            "secret" => [
                "required",
                "string",
                function ($attribute, $value, $fail) use ($ticket) {
                    if ($ticket->secret !== $value) {
                        $fail("The ticket secret is invalid.");
                    }
                }
            ],
        ]);

        $validation = $ticket->validate($event);
        if ($validation["ticketValidationResult"] !== "valid") {
            return response()->json(["message" => $validation["error"]], 422);
        }

        $ticket->checkins()->create([
            'event_id' => $event->id,
            'user_id' => auth()->user()->id,
        ]);

        return response()->json(["message" => "Das Ticket wurde erfolgreich eingecheckt."], 200);
    }

    public function validateTicket(Ticket $ticket, Event $event, Request $request){
        $request->validate([
            "secret" => [
                "required",
                "string", 
                function ($attribute, $value, $fail) use ($ticket) {
                    if ($ticket->secret !== $value) {
                        $fail("The ticket secret is invalid.");
                    }
                }
            ],
        ]);
        return response()->json($ticket->validate($event), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}