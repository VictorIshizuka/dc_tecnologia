<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|integer|min:1',
        ];
    }
}
