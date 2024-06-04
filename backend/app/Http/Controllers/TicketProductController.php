<?php

namespace App\Http\Controllers;

use App\Models\TicketProduct;
use Illuminate\Http\Request;

class TicketProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('ticket.product.index', [
            'products' => TicketProduct::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ticket.product.create');
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
    public function show(TicketProduct $ticket)
    {
        return view('ticket.product.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TicketProduct $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TicketProduct $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TicketProduct $ticket)
    {
        //
    }
}