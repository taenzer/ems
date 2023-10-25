<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class ApiOrderController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            "*.event_id" => "required_without:*.eventId",
            "*.eventId" => "required_without:*.event_id",
            "*.created" => "nullable",
            "*.created_at" => "nullable",
            "*.gateway" => "required|string",
            "*.total" => "required|numeric",
            "*.items" => "required|array",
            "*.items.*.product_id" => "required_without:*.items.*.productId",
            "*.items.*.productId" => "required_without:*.items.*.product_id",
            "*.items.*.price" => "required_with:*.items.*|numeric",
            "*.items.*.quantity" => "required_with:*.items.*|integer",
            "*.items.*.itemTotal" => "required_with:*.items.*|numeric",
        ]);
        //return $attributes;
        foreach ($attributes as $order_data) {
            $order_data['event_id'] = $order_data['eventId'] ?? $order_data['event_id'] ?? null;
            $order_data['created_at'] = $order_data['created'] ?? $order_data['created_at'] ?? null;
            unset($order_data['eventId'], $order_data['created']);
            
            $order = Order::create($order_data);
            foreach ($order_data["items"] as $item_data) {
                $item_data["product_id"] = $item_data["product_id"] ?? $item_data["productId"] ?? null;
                unset($item_data["productId"]);
                $item_data["order_id"] = $order->id;
                OrderItem::create($item_data);
            }
        }
        return $order;
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}