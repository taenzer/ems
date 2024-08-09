<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\TicketProduct;
use App\Models\TicketPermit;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ["name", "date", "time", "user_id"];
    protected $appends = ["product_sets"];
    protected $hidden = ["product_sets", "product_data"];

    protected function time(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format("H:i"),
        );
    }

    protected function getProductSetsAttribute()
    {
        $products = $this->products;
        return "TODO";
    }

    public function saleGateways()
    {
        return $this->orders->pluck("gateway")->unique();
    }

    public function dateString()
    {
        return Carbon::parse($this->date)->format("d.m.Y");
    }

    public function timeString()
    {
        return Carbon::parse($this->time)->format("H:i") . " Uhr";
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->as("product_data")->withPivot(['price', 'prio'])->withTimestamps();
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function ticketProducts()
    {
        return $this->hasManyThrough(TicketProduct::class, TicketPermit::class, "event_id", "id", "id", "ticket_product_id");
    }

    public function tickets()
    {
        return $this->hasManyThrough(Ticket::class, TicketPermit::class, "event_id", "ticket_product_id", "id", "ticket_product_id");
    }

    public function ticketPermits()
    {
        return $this->hasMany(TicketPermit::class);
    }

    public function sellers()
    {
        return $this->hasManyThrough(User::class, Order::class, "event_id", "id", "user_id", "id");
    }
}