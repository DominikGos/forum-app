<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
    
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'email|max:255|required|unique:users,email',
            'login' => 'string|required|max:255|regex:/[a-zA-Z0-9]+$/|unique:users,login',
            'first_name' => 'string|max:255|required',
            'last_name' => 'string|max:255|required',
            'password' => 'string|max:255|required|regex:/[a-zA-Z0-9]+$/'
        ];
    }
}
