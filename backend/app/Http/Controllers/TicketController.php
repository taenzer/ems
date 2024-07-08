<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketOrder;
use App\Models\Event;
use Illuminate\Http\Request;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Carbon\Carbon;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {

        $events = auth()->user()->getEvents();
        $ticketSalesPerEvent = collect();
        $events->map(function ($event) use ($ticketSalesPerEvent){
            $ticketSalesPerEvent->put($event->name, $event->tickets->count());
        });

        $ticketSalesPerDay = collect();
        $tickets = auth()->user()->getEventTickets();
        $tickets = $tickets->map(function ($ticket) {
            return $ticket->created_at->format('Y-m-d');
        });
        $ticketStats = array_count_values($tickets->toArray());
        
        // Erstes und letztes Datum bestimmen
        if (!empty($ticketStats)) {
            $firstDate = Carbon::parse(array_key_first($ticketStats));
            $firstDate->subDay(1);
        } else {
            $firstDate = Carbon::today();
        }
        $lastDate = Carbon::today()->addDay(1);

        for ($date = $firstDate; $date->lte($lastDate); $date->addDay()) {
            $dt = $date->format('Y-m-d');
            $ticketSalesPerDay->put($dt, $ticketStats[$dt] ?? 0);
        }

        return view('ticket.index', [
            'ticketSalesPerEvent' => $ticketSalesPerEvent,
            'ticketSalesPerDay' => $ticketSalesPerDay,
            'events' => $events,
        ]);
    }

     /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
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