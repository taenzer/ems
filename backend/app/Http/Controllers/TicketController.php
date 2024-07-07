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
        $columnChartModel = (new ColumnChartModel())->setTitle('Ticketverkäufe nach Veranstaltung');
        
        $events->map(function ($event) use ($columnChartModel){
            $columnChartModel->addColumn($event->name, $event->tickets->count(), "#dedede");
        });

        $salesChartModel = (new LineChartModel())->setTitle('Ticketverkäufe nach Datum')->singleLine();
        $salesData = collect();
        $tickets = auth()->user()->getEventTickets();

        $tickets = $tickets->map(function ($ticket) {
            return $ticket->created_at->format('Y-m-d');
        });

        $ticketStats = array_count_values($tickets->toArray());
        // Erstes und letztes Datum bestimmen
        if (!empty($ticketStats)) {
            $firstDate = Carbon::parse(array_key_first($ticketStats));
        } else {
            $firstDate = Carbon::today();
        }
        $lastDate = Carbon::today();

        // Leeres Array mit allen möglichen Daten initialisieren
        $dateRange = array();
        for ($date = $firstDate; $date->lte($lastDate); $date->addDay()) {
            $dt = $date->format('Y-m-d');
            $salesChartModel->addPoint($date->format('d.m.Y'), isset($ticketStats[$dt]) ? $ticketStats[$dt] : 0);     
        }



        $columnChartModel->setAnimated(true)
            ->setXAxisVisible(true)
            ->withoutLegend()
            ->setDataLabelsEnabled(true);


        return view('ticket.index', [
            'columnChartModel' => $columnChartModel,
            'salesChartModel' => $salesChartModel,
            'events' => $events,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
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