<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketCheckin extends Model
{
    use HasFactory;

    public $fillable = ['ticket_id', 'event_id', 'user_id'];

    public function ticket(){
        return $this->belongsTo(Ticket::class);
    }

    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function checkedInBy(){
        return $this->belongsTo(User::class);
    }
}
