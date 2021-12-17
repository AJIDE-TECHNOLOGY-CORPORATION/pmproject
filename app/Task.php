<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /* customer relation */
    public function project() {
        return $this->belongsTo(Project::class,'project_id','id');
    }

}
