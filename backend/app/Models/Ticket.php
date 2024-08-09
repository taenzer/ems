<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Cast\Bool_;

class Ticket extends Model
{
    use HasFactory;

    public $fillable = ['ticket_product_id', 'ticket_price_id', 'secret', 'boxoffice_fee'];

    public function ticketOrder()
    {
        return $this->belongsTo(TicketOrder::class);
    }

    public function ticketPrice()
    {
        return $this->belongsTo(TicketPrice::class);
    }

    public function price()
    {
        return $this->ticketPrice->price + $this->boxoffice_fee;
    }

    public function ticketProduct()
    {
        return $this->belongsTo(TicketProduct::class);
    }

    public function checkins()
    {
        return $this->hasMany(TicketCheckin::class);
    }

    public function permits()
    {
        return $this->hasManyThrough(TicketPermit::class, TicketProduct::class, 'id', 'ticket_product_id', 'ticket_product_id', 'id');
    }

    public function validate(Event $event)
    {
        if ($this->permits()->where("event_id", $event->id)->count() == 0) {
            return array("ticketValidationResult" => "notForThisEvent", "error" => "Das Ticket ist nicht für diese Veranstaltung gültig.");
        }

        if ($this->checkins()->where("event_id", $event->id)->count() != 0) {
            return array("ticketValidationResult" => "alreadyCheckedIn", "error" => "Das Ticket wurde bereits eingecheckt.");
        }
        return array("ticketValidationResult" => "valid");
    }

    static function generateSecret($length = 8)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}