<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'document', 'email', 'phone'];

    public function salesOrders()
    {
        return $this->hasMany(SalesOrder::class);
    }
}
