<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /* order details relation */
    public function orderItemDetails() {
        return $this->hasMany(OrderDetail::class,'order_id','id');
    }

    /* customer relation */
    public function customer() {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }

    /* invoice relation */
    public function invoice() {
        return $this->belongsTo(Invoice::class,'invoice_id','id');
    }

}
