<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class ForumUpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => [
                'nullable', 'min:3', 'max:255', Rule::unique('forums')->ignore($this->route('id'))
            ],
            'description' => 'nullable|min:3|max:255',
            'image' => [
                'nullable', File::image()->types(['image/jpeg', 'image/png'])
            ]
        ];
    }
}
