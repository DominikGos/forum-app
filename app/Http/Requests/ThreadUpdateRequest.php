<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ThreadUpdateRequest extends FormRequest
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
            'user_id' => 'required|integer',
            'title' => [
                'nullable', Rule::unique('threads')->ignore($this->route('id'))
            ],
            'description' => 'nullable',
            'tagIds' => 'nullable|array|',
            'tagIds.*' => 'integer',
        ];
    }
}
