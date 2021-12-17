<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /* customer relation */
    public function customer() {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
}