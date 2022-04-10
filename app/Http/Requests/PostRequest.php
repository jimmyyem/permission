<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            "user_id" => "required|integer",
            "title" => "required|max:255",
            "body" => "required",
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
            'user_id.required' => '发布人为空',
            'user_id.integer' => '发布人必须选择',
            'title.required' => '标题为空',
            'title.max' => '标题最多255个字',
            'body.required' => '内容不能为空',
        ];
    }
}
