<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    protected $fillable = ['sales_order_id', 'installment_number', 'amount', 'due_date'];

    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class);
    }
}
