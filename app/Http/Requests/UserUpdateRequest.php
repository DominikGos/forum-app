<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class UserUpdateRequest extends FormRequest
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
        return [//regex not working
            'email' => [
                'email', 'max:255', Rule::unique('users')->ignore(Auth::id()), 'nullable'
            ],
            'login' => [
                'min:2', 'max:255', Rule::unique('users')->ignore(Auth::id()), 'nullable'
            ],
            'first_name' => 'min:2|string|max:255|nullable',
            'last_name' => 'min:2|string|max:255|nullable',
            'description' => 'min:3|string|max:255|nullable',
            'avatar_path' => 'string|nullable'
        ];
    }
}
