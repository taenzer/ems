<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ["name", "date", "time", "user_id"];

    protected function time():Attribute{
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->format("H:i"),
        );
    }

    public function dateString(){
        return Carbon::parse($this->date)->format("d.m.Y");
    }

    public function timeString(){
        return Carbon::parse($this->time)->format("H:i")." Uhr";
    }

    public function products(){
        return $this->belongsToMany(Product::class)->as("product_data")->withPivot(['price', 'prio'])->withTimestamps();
    }
}