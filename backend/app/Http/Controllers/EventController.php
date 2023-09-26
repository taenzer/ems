<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('event.index', [
        'events' => Event::all() 
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

        return redirect(route("event.show", ["event" => $event]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return view('event.show',[
            'event' => $event
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
        return redirect(route("event.show", ["event" => $event]))->with('success', 'Event aktualisiert');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}