<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventProductLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Event $event)
    {

        $products = Product::whereDoesntHave('events', function (Builder $query) use($event) {
            $query->where('id', '=', $event->id);
        })->orderBy("type", "DESC")->orderBy("name", "ASC")->get();

        return view("event_product_link.create", [
            "event" => $event,
            "product_sets" => $products->groupBy("type")
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event)
    {


        $attributes = $request->validate([
                    "products" => "required|array|min:1",
                    "products.*" => "required|array:product_id,price",
                    "products.*.product_id" => "required_with:products.*|integer|exists:products,id",
                    "products.*.price" => "required_with:products.*|numeric"
        ]);
        $event->products()->attach($attributes["products"]);
       
        return redirect(route("events.show", ["event" => $event]));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $attributes = $request->validate([
                    "products" => "required|array|min:1",
                    "products.*" => "required|array:product_id,price",
                    "products.*.product_id" => "required_with:products.*|integer|exists:products,id",
                    "products.*.price" => "required_with:products.*|numeric"
        ]);

        $event->products()->sync($attributes["products"]);
       
        return redirect(route("events.show", ["event" => $event]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}