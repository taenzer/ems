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

    public function sharedEvents()
    {
        return $this->belongsToMany(Event::class, 'shares', 'shared_to');
    }

    public function getEvents()
    {
        return $this->hasMany(Event::class)->get()->merge($this->sharedEvents);
    }

    public function getEventTickets(){
        $events = $this->getEvents();
        $tickets = collect();
        $events->map(function($event) use ($tickets){
            $event->tickets->map(function($ticket) use ($tickets){
                
                    $tickets->put($ticket->id, $ticket);
                
                
            });
        });
        return $tickets->values();
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