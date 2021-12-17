<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerPaymentHistory extends Model
{
    /* invoice details */
    public function invoice() {
        return $this->belongsTo(Invoice::class,'invoice_id','id');
    }
}
