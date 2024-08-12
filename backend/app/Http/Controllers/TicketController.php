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
        // First, get all TicketOrders of the Event
        $eventTicketOrders = $event->ticketProducts->flatMap(function ($products) {
            return $products->orders;
        });
        // Group the orders by gateway
        $ticketsByGateway = $eventTicketOrders->groupBy('gateway')
            // Now map over all orders to get the Tickets
            ->map(function ($orders) use ($event) {
                // Extract the Tickets of the order
                return $orders->flatMap(function ($order) use ($event) {
                    return $order->tickets->filter(function ($ticket) use ($event) {
                        return $ticket->validate($event)["ticketValidationResult"] != "notForThisEvent";
                    });
                })
                    // Group them by TicketPrice and TicketProduct
                    ->groupBy(function ($ticket) {
                        return $ticket->ticket_product_id . "-" . $ticket->ticket_price_id;
                    })
                    // Map over them to calculate counts
                    ->map(function ($tickets) use ($event) {
                        return [
                            "ticket_product" => $tickets->first()->ticketProduct,
                            "ticket_price" => $tickets->first()->ticketPrice,
                            // Tickets Sold = trivial
                            "tickets_sold" => $tickets->count(),
                            // Get Ticket Checkins of the ticket, filter and count them
                            "tickets_checkins" => $tickets->flatMap(function ($ticket) use ($event) {
                                // filter because we only want checkins of the selected event
                                return $ticket->checkins->filter(function ($checkin) use ($event) {
                                    return $checkin->event_id == $event->id;
                                });
                            })->count()
                        ];
                    })
                ;
            });



        return view('ticket.analytics', ["event" => $event, "ticketsByGateway" => $ticketsByGateway]);
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
