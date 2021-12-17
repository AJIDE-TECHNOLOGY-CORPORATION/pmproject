<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{


    /* customer relation */
    public function customer() {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }

    /* invoice details relation */
    public function invoiceItemDetails() {
        return $this->hasMany(InvoiceDetails::class,'invoice_id','id');
    }

}