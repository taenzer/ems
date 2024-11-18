<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Share;
use App\Models\Event;
use App\Models\User;

class EventOwnerOrShareOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $event = $request->route("event");

        if(!isset($event) || !($event instanceof Event))
            return $next($request);
        
        if($event->user_id != auth()->id() && !auth()->user()->sharedEvents->contains($event))
            return abort(403, "Zugriff verweigert");

        if($event->user_id == auth()->id()){
            $request->attributes->set("permission", "owner");
        }else{
            $share = Share::where("event_id", $event->id)->where("shared_to", auth()->id())->first();
            $request->attributes->set("permission", $share->permission);
        }
        return $next($request);
    }
}