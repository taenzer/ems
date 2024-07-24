<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TicketPrice;
use App\Models\TicketPermit;
use App\Models\TicketDesign;

class TicketProduct extends Model
{
    use HasFactory;

    public $fillable = ["name", "tixAvailable", "ticket_design_id", "boxoffice_fee"];

    public function prices(){
        return $this->hasMany(TicketPrice::class);
    }

    public function permits(){
        return $this->hasMany(TicketPermit::class);
    }

    public function permittedEvents(){
        return $this->belongsToMany(Event::class, 'ticket_permits');
    }

    public function design(){
        return $this->belongsTo(TicketDesign::class, 'ticket_design_id');
    }
}