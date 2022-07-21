<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded=[];

    public function receiver(){
        return $this->belongsTo(User::class,"receiver_");
    }

    public function sender(){
        return $this->belongsTo(User::class,"sender_id");
    }
}
