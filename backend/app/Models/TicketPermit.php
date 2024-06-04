<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketPermit extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $fillable = ["event_id"];
}