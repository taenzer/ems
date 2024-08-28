<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Share;
use App\Models\TicketProduct;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class EventController extends Controller
{

    public function generateReport(Request $request, Event $event)
    {

        $attributes = $request->validate([
            "report-type" => "required|String",
            "gateways" => "required|Array",
            "user" => "nullable|Integer"
        ]);

        $orders = $event->orders;
        $orderItems = $orders->flatMap(function($order){
            return $order->items;
        })->groupBy("product_id")->map(function($items, $product_id){
            return collect([
                "product" => Product::find($product_id),
                "itemsSold" => $items->sum("quantity"),
                "prices" => $items->groupBy("price")->mapWithKeys(function($priceGroup){
                    return [ strval($priceGroup->first()->price) => $priceGroup->sum("quantity")];
                }),
                "salesVolume" => $items->sum("itemTotal")
            ]);
        });
        $pdf = Pdf::loadView('pdf.reports.sales', array("orderItems" => $orderItems, "event" => $event, "gateways" => $attributes["gateways"]));
        return $pdf->download("report.pdf");
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shares = auth()->user()->sharedEvents;
        return view('event.index', [
            'events' => Event::where('user_id', auth()->user()->id)->get()->merge($shares)->sortByDesc('date'),
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
}
