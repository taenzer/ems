<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ["name", "type", "default_price", "user_id", "image"];
    public static function getTypes()
    {
        return ["food" => "Speisen", "drinks" => "Getränke"];
    }

    public function type()
    {
        return Product::getTypes()[$this->type] ?? "?";
    }


    public function events()
    {
        return $this->belongsToMany(Event::class)->as("product_data")->withPivot(["price"])->withTimestamps();
    }
}
