<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /* order relation */
    public function invoiceDetails() {
        return $this->hasMany(Invoice::class,'customer_id','id');
    }
}