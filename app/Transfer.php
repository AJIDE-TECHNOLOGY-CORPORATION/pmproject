<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
      /* account holder relation */
      public function account_from() {
        return $this->belongsTo(Bank::class,'from_id','id');
    }

    public function account_to() {
        return $this->belongsTo(Bank::class,'to_id','id');
    }
}
