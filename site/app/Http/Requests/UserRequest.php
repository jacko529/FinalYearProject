<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|min:2',
            'surname' => 'required|min:2',
            'email' => 'required|email',
            'password' => 'required|min:5'
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'first_name.required' => 'First name is required!',
            'surname.required' => 'Last name is required!',
            'email.required' => 'Email is required!',
            'password.required' => 'Password is required'
        ];
    }
}
