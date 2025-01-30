<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Http\Resources\EventCollection;

class ApiEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return auth()->user()->getEvents(true)
        ->map(function ($event) {
            unset($event->created_at, $event->updated_at, $event->active, $event->user_id); // Entferne bestimmte Attribute
            return $event;
        });
    }

    public function getTicketProducts(Event $event)
    {
        return $event->ticketProducts()->with("prices")->with("permittedEvents")->get();
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
        if ($event->user_id != auth()->user()->id) {
            throw new AuthorizationException();
        }
        return $event->load("products")->makeVisible("product_sets");
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