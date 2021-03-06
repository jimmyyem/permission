<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            "email" => "required|email",
            "password" => "required|min:8",
        ];
    }

    /**
     * error message
     *
     * @return string[]
     */
    public function messages()
    {
        return [
            'email.required' => '必须填写邮箱',
            'email.email' => '邮箱格式错误',
            'password.required' => '必须填写密码',
            'password.min' => '密码至少八位',
        ];
    }
}
