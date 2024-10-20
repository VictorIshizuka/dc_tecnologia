<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    protected $fillable = ['customer_id', 'user_id', 'payment_type_id', 'total_amount'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class); // Vendedor
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function items()
    {
        return $this->hasMany(SalesOrderItem::class);
    }

    public function installments()
    {
        return $this->hasMany(Installment::class);
    }
}
