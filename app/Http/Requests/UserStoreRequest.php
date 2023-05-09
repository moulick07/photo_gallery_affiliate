<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
        $rules = [
            'image.*.title' => 'required',
            'image.*.tag' => 'required',
            'image.*.price' => 'required',
            'image.*.file' => 'required'
        ];
        
            return $rules;
        
    }
}
