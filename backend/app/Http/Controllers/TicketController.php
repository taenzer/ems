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
        $events->map(function ($event) use ($ticketSalesPerEvent) {
            $ticketSalesPerEvent->put($event->name, $event->tickets->count());
        });

        $ticketSalesPerDay = collect();
        $tickets = auth()->user()->getEventTickets();
        $ticketSales = $tickets->map(function ($ticket) {
            return $ticket->created_at->format('Y-m-d');
        });
        $ticketStats = array_count_values($ticketSales->toArray());

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

        $ticketSalesPerGateway = $tickets->map(function ($ticket) {
            return $ticket->ticketOrder->gateway;
        })->countBy();

        return view('ticket.index', [
            'ticketSalesPerEvent' => $ticketSalesPerEvent,
            'ticketSalesPerDay' => $ticketSalesPerDay,
            'ticketSalesPerGateway' => $ticketSalesPerGateway,
            'events' => $events,
        ]);
    }

    public function analytics(Event $event)
    {
        $sales = $event->tickets->map(function($ticket){
            return collect([
                "gateway" => $ticket->ticketOrder->gateway,
                "ticket" => $ticket->ticketProduct->name . " - " . $ticket->ticketPrice->category
            ]);
        })->groupBy("gateway")->map(function($tickets){
            return $tickets->countBy("ticket");
        });

        $checkins = $event->checkedInTickets->map(function($ticket){
            return collect(["gateway" => $ticket->ticketOrder->gateway, "ticket" => $ticket->ticketProduct->name . " - " . $ticket->ticketPrice->category]);
        })->groupBy("gateway")->map(function ($tickets) {
            return $tickets->countBy("ticket");
        });

        $ticketStatsByGateway = $sales->map(function($sales, $gateway) use ($checkins){
            return $sales->map(function($saleCount, $ticket) use ($checkins, $gateway){
                $checkinsCount = data_get($checkins, $gateway.".".$ticket, 0);
                return collect(["sells" => $saleCount, "checkins" => $checkinsCount]);
            });
        });

        return view('ticket.analytics', ["event" => $event, "ticketStatsByGateway" => $ticketStatsByGateway]);
    }

    /**
     * Helper function to easily check in all tickets sold at the boxoffice
     */
    public function checkInAllBoxofficeTickets(Event $event)
    {
        $tickets = $event->tickets
            ->filter(function ($ticket) {
                return in_array($ticket->ticketOrder->gateway, array("BO-BAR", "BO-CARD"));
            })
            ->filter(function ($ticket) use ($event) {
                return $ticket->checkins->filter(function ($checkin) use ($event) {
                    return $checkin->event_id == $event->id;
                })->count() == 0;
            });

        $tickets->map(function ($ticket) use ($event) {
            $ticket->checkins()->create([
                "event_id" => $event->id,
                "user_id" => auth()->user()->id,
            ]);
        });
        return back();
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
