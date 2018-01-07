<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UserRequest extends FormRequest
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
     * @param Request $request
     * @return array
     */
    public function rules(Request $request)
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'username' => 'required|string|max:30|unique:users,username',
                    'email' => 'required|string|email|max:255|unique:users,email',
                    'password' => 'required|string',
                    'firstname' => 'required|string|max:100',
                    'lastname' => 'required|string|max:100',
                    'avatar' => 'image|mimes:jpeg,bmp,png|max:2048',
                    'free_download' => 'required|numeric',
                    'wallet' => 'required|numeric',
                ];
            case 'PUT':
                return [
                    'username' => 'required|string|max:30|unique:users,username,' . $request->get('id'),
                    'email' => 'required|string|email|max:255|unique:users,email,' . $request->get('id'),
                    'firstname' => 'required|string|max:100',
                    'lastname' => 'required|string|max:100',
                    'avatar' => 'image|mimes:jpeg,bmp,png|max:2048',
                    'free_download' => 'required|numeric',
                    'wallet' => 'required|numeric',
                ];
        }
    }
}
