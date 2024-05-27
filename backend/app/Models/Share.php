<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Share extends Model
{
    use HasFactory;

    public function sharedTo(){
        return $this->belongsTo(User::class, "shared_to");
    }
}