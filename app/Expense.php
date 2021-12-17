<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{

    /* customer relation */
    public function customer() {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }

    /* expense category relation */
    public function expenseCategory() {
        return $this->belongsTo(ExpenseCategory::class,'expense_category_id','id');
    }

}