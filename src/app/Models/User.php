<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function isAdmin(){
        return $this->is_admin;
    }

    public function events(){
        return $this->hasMany(Event::class);
    }
    public function sharedEvents()
    {
        return $this->belongsToMany(Event::class, 'shares', 'shared_to');
    }


    public function getEvents(bool $onlyActive = true, bool $currentYear = false, bool $paginated = false){
        // Basis-Query für alle Events
        $query = Event::query();

        // Admin-Sonderfall: Admin sieht alle Events, aber die Filter gelten trotzdem
        if (!($this->is_admin && session('superadmin', false)) ) {
            // Für normale Benutzer: Eigene und freigegebene Events kombinieren
            $ownEventsQuery = $this->events();
            $sharedEventsQuery = $this->sharedEvents()->select("events.*");

            $query = $ownEventsQuery->union($sharedEventsQuery);
        }

        // Bedingung: Nur aktive Events
        if ($onlyActive) {
            $query->where('active', true);
        }

        // Bedingung: Nur Events aus dem aktuellen Jahr
        if ($currentYear) {
            $currentYear = Carbon::now()->year;
            $query->where(function ($subQuery) use ($currentYear) {
                $subQuery->whereYear('date', $currentYear)
                    ->orWhere('active', true);
            });
        }

        $query->orderByDesc('date');

        // Ergebnisse abrufen
        return $paginated ? $query->paginate() : $query->get();
    }

    public function getEventTickets()
    {
        $events = $this->getEvents();
        $tickets = collect();
        $events->map(function ($event) use ($tickets) {
            $event->tickets->map(function ($ticket) use ($tickets) {

                $tickets->put($ticket->id, $ticket);
            });
        });
        return $tickets->values();
    }

    public function ticketOrders()
    {
        return $this->hasMany(TicketOrder::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}