<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
// use Illuminate\Validation\Rule;

class CreateCustomerRequest extends FormRequest
{
    public function rules(): array
    {

        // $customerId = $this->route('customer');

        return [
            'name' => 'required|min:3|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                // Rule::unique('customers')->ignore($customerId),
            ],
            'document' => [
                'required',
                'string',
                'min:15',
                'max:15',
                // Rule::unique('customers')->ignore($customerId),
            ],
            'phone' => 'required|string|min:11|max:15',
        ];
    }
}
