<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /* customer relation */
    public function customer() {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }

}
