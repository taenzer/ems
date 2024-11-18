<?php

namespace App\Http\Controllers;

use App\Models\Share;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class ShareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Event $event)
    {
        return view("event_shares.index",[ "event" => $event, "shares" => Share::where("event_id", $event->id)->get()]);
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
        $attributes = request()->validate([
            'email' => 'required|exists:users,email',
            'permission' => 'required|in:view,edit',
        ]);

        $sharedTo = User::where("email", $attributes['email'])->first();
        if($sharedTo->id == auth()->id()){
            return back()->withErrors(["email" => "Du kannst das nicht mit dir selber freigeben!"]);
        }


        $share = new Share();
        $share->shared_from = auth()->id();
        $share->shared_to = $sharedTo->id;
        $share->event_id = $request->event;
        $share->permission = $attributes['permission'];
        $share->save();

        return redirect(route("events.shares.index", ["event" => $request->event]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Share $share)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Share $share)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Share $share)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event, Share $share)
    {
        $share->delete();
        return redirect(route("events.shares.index", ["event" => $event->id]));
    }
}