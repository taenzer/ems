<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['event_id','gateway', 'total','created_at'];

    public function setCreatedAttribute($value){
        $this->attributes['created_at'] = $value;
    }

    public function items(){
        return $this->hasMany(OrderItem::class);
    }

    public function meta(){
        return $this->hasMany(OrderMeta::class);
    }

    public function event(){
        return $this->belongsTo(Event::class);
    }
}