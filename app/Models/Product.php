<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'stock'];

    public function salesOrderItems()
    {
        return $this->hasMany(SalesOrderItem::class);
    }
}
