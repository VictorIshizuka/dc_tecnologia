<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'document' => 'required|string|min:15|max:15|unique:users,document',
            'phone' => 'required|string|min:15|max:10',
            'password' => 'required|string|min:6|confirmed',
        ];
    }
}
