<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    protected $fillable = ['name'];

    public function salesOrders()
    {
        return $this->hasMany(SalesOrder::class);
    }
}
