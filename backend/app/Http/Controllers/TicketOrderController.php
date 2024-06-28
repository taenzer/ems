<?php

namespace App\Http\Controllers;

use App\Models\TicketOrder;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("ticket.order.index", ['orders' => TicketOrder::where("user_id", auth()->user()->id)->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("ticket.order.create");
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
    public function show(TicketOrder $ticketOrder)
    {
        return view("ticket.order.show", ["order" => $ticketOrder]);
    }

    public function downloadTickets(TicketOrder $ticketOrder)
    {
        $tickets = $ticketOrder->tickets()->with(["ticketPrice", "ticketProduct"])->get();
        $pdf = Pdf::loadView('pdf.ticket', array("tickets" => $tickets));
        return $pdf->download("ems-tickets-" . $ticketOrder->id . ".pdf");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TicketOrder $ticketOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TicketOrder $ticketOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TicketOrder $ticketOrder)
    {
        //
    }
}