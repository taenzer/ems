<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    public $fillable = ['ticket_product_id', 'ticket_price_id', 'secret'];

    public function ticketOrder(){
        return $this->belongsTo(TicketOrder::class);
    }

    public function ticketPrice(){
        return $this->belongsTo(TicketPrice::class);
    }

    public function ticketProduct(){
        return $this->belongsTo(TicketProduct::class);
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
