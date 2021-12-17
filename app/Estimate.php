<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estimate extends Model
{
    /* customer relation */
    public function customer() {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }

    /* estimate details relation */
    public function estimateItemDetails() {
        return $this->hasMany(EstimateDetails::class,'estimate_id','id');
    }
}