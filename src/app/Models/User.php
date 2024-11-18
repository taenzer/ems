<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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

    public function events(){
        return $this->hasMany(Event::class);
    }
    public function events(){
        return $this->hasMany(Event::class);
    }
    public function sharedEvents()
    {
        return $this->belongsToMany(Event::class, 'shares', 'shared_to');
    }

    public function allAccessibleEvents($onlyActive = true)
    {
        if($onlyActive){
            return $this->events()->where("active", true)->union($this->sharedEvents()->where("active", true)->select("events.*"))->orderByDesc("date");
        }else{
            return $this->events()->union($this->sharedEvents()->select("events.*"))->orderByDesc("date");
        }
    }

    public function getEvents($onlyActive = true){
        return $this->allAccessibleEvents($onlyActive)->orderBy('date', 'asc')->get();
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