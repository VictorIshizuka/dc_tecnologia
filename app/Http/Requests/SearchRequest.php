<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'sales_order_id' => 'nullable|required_without_all:sales_order_user,payment_type,sales_order_product,sales_order_installments,sales_order_due_date',
            'sales_order_user' => 'nullable|required_without_all:sales_order_id,payment_type,sales_order_product,sales_order_installments,sales_order_due_date',
            'payment_type' => 'nullable|required_without_all:sales_order_id,sales_order_user,sales_order_product,sales_order_installments,sales_order_due_date',
            'sales_order_product' => 'nullable|required_without_all:sales_order_id,sales_order_user,payment_type,sales_order_installments,sales_order_due_date',
            'sales_order_installments' => 'nullable|required_without_all:sales_order_id,sales_order_user,payment_type,sales_order_product,sales_order_due_date',
            'sales_order_due_date' => 'nullable|required_without_all:sales_order_id,sales_order_user,payment_type,sales_order_product,sales_order_installments',
        ];
    }
}