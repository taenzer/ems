<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ["name", "type", "default_price", "user_id"];
    public static function getTypes(){
        return ["food" => "Speisen", "drinks" => "Getränke"];
    }

    public function type(){
        return Product::getTypes()[$this->type] ?? "?";
    }
    use HasFactory;
}