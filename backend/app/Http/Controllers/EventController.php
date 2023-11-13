<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class EventController extends Controller
{

    public function generateReport(Request $request, Event $event){

        $attributes = $request->validate([
            "report-type" => "required|String",
            "gateways" => "nullable|Array"
        ]);

        // Get and group the order items by product_id, name and price
        $items = 
            OrderItem::with("order") // Select all OrderItems with the Order Data
                ->whereHas('order', function($q) use($event) {
                    $q->where("event_id", $event->id); // Only Items of Orders of the selected Event
                })
                ->whereHas('order', function($q) use($attributes) {
                    $q->whereIn("gateway", $attributes["gateways"]); // Only Items of Orders with the given gateway
                })
                ->get()
                ->groupBy('product_id')
                ->map(function($i){ 
                    return array(
                        "totalQuantity" => $i->sum("quantity"),
                        "totalItemTotal" => $i->sum("itemTotal"), 
                        "grouped" => $i->groupBy('name')
                                        ->map(function ($item) {
                                            $ret = $item->groupBy("price")->map(function($ps){
                                                return array("price" => $ps->first()->price, "name" => $ps->first()->name, "quantity" => $ps->sum("quantity"), "itemTotal" => $ps->sum("itemTotal"));
                                            });
                                            return $ret;
                                        }),
                        );
                });

                /* Never Change a running System... not shure how it works, but it works! */

        
        $pdf = Pdf::loadView('pdf.reports.sales', array("orderItems" => $items));
        return $pdf->stream();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('event.index', [
            'events' => Event::where('user_id', auth()->user()->id)->get()
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
        $prods = $event->products()->orderByPivot("prio", "desc")->get();

        return view('event.show', [
            'event' => $event,
            'products' => $prods,
            'product_sets' => $prods->sortBy("type")->groupBy("type"),
            'orders' => $event->orders()->orderBy('created_at', 'desc')->with('items')->paginate(5),
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
}