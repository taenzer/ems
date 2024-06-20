<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;
use App\Models\TicketProduct;

class TicketPermit extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $fillable = ["event_id"];

    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function ticketProduct(){
        return $this->belongsTo(TicketProduct::class);
    }
}