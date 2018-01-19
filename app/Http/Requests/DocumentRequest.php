<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest
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
        switch ($this->method()) {
            case 'PUT':
                return [
                    'title' => 'required|min:20|max:255',
                    'category' => 'required|numeric',
                    'subcategory' => 'numeric',
                    'coin' => 'required|numeric',
                    'description' => 'required',
                ];
        }
    }
}
