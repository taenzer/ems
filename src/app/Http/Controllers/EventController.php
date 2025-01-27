<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Services\Analytics;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class EventController extends Controller
{

    public function showOrderProtocoll(Event $event){
        return view('event.orderProtocoll', [
            "event" => $event
        ]);
    }

    public function generateReport(Request $request, Event $event)
    {
        $attributes = $request->validate([
            "report-type" => "required|String",
            "gateways" => "required|Array",
            "user" => "nullable|Integer"
        ]);

        if($attributes["report-type"] == "sales"){
            $productSaleStats = Analytics::getEventProductSaleStats($event, $attributes["gateways"]);
            $pdf = Pdf::loadView('pdf.reports.sales', array("orderItems" => $productSaleStats, "event" => $event, "gateways" => $attributes["gateways"]));
            $filename = "ems-report-{$event->date}-" . strtolower(preg_replace('/\s+/', '', $event->name)) . "-sales-" . implode("-", $attributes['gateways']) . ".pdf";
            return $pdf->download($filename);
        }else if($attributes["report-type"] == "tickets"){
            $ticketSaleStats = Analytics::getEventTicketSaleStats($event, $attributes["gateways"]);
            $pdf = Pdf::loadView('pdf.reports.tickets', array("ticketSaleStats" => $ticketSaleStats, "event" => $event, "gateways" => $attributes["gateways"]));
            $filename = "ems-report-{$event->date}-" . strtolower(preg_replace('/\s+/', '', $event->name)) . "-tickets-" . implode("-", $attributes['gateways']) . ".pdf";
            return $pdf->download($filename);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('event.index', [
            'events' => auth()->user()->getEvents(false, !$request->has('include_archived'), true),
            'include_archived' => $request->has('include_archived'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('event.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $attributes = request()->validate([
            'name' => 'required',
            'date' => 'required|date_format:Y-m-d|after:yesterday',
            'time' => 'required|date_format:H:i'
        ]);


        $attributes['user_id'] = auth()->id();

        $event = Event::create($attributes);

        return redirect(route("events.show", ["event" => $event]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {

        // dd(request()->attributes->get("permission"));
        $prods = $event->products()->orderByPivot("prio", "desc")->get();

        $orders = $event->orders;
        $orderStatsByGateway = $orders->groupBy("gateway")->map(function ($orders) {
            $items = $orders->flatMap(function ($order) {
                return $order->items;
            });
            return collect([
                "items" => $items->count(),
                "total" => $items->sum("itemTotal"),
                "avg_total" => $orders->avg("total"),
                "orders" => $orders->count(),
                // We only want bestsellers with positive price
                "bestseller" => $items->where("price", ">", 0)->groupBy("name")->map(function ($item) {
                    return $item->sum("quantity");
                })->sortDesc()
            ]);
        });
        return view('event.show', [
            'event' => $event,
            'products' => $prods,
            'product_sets' => $prods->sortBy("type")->groupBy("type"),
            'orders' => $event->orders()->orderBy('created_at', 'desc')->with('items')->paginate(5),
            'orderStatsByGateway' => $orderStatsByGateway,
            'permission' => 2,
            'ticketProducts' => $event->ticketProducts,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view("event.edit", [
            "event" => $event
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $attributes = request()->validate([
            'name' => 'required',
            'date' => 'required|date_format:Y-m-d|after:yesterday',
            'time' => 'required|date_format:H:i'
        ]);

        $event->update($attributes);
        return redirect(route("events.show", ["event" => $event]))->with('success', 'Event aktualisiert');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }


    public function toggleStatus(Event $event)
    {
        $event->active = !$event->active;
        $event->save();
        return redirect(route("events.show", [
            "event" => $event
        ]));
    }

    public function advancedProductSettings(Event $event){
        return view("event.product-settings", ["event" => $event]);
    }
}
