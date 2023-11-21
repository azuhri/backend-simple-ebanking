<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    function sender() {
        return $this->belongsTo(User::class, "sender_id","id");
    }

    function receiver() {
        return $this->belongsTo(User::class, "receiver_id","id");
    }

}
