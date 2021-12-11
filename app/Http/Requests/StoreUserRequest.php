<?php

namespace App\Http\Requests;

use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|numeric',
            'address' => 'required|string',
            'password' => '$this->passwordRules()',
            'receipt_of_payment' => 'required|image',
        ];
    }
}
