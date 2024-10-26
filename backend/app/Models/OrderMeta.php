<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderMeta extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value'];
    public $timestamps = false;

    public function order(){
        return $this->belongsTo(Order::class);
    }
}
