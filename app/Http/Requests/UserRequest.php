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
            'username'  => 'required|unique:users|max:250',
            'password'  => 'required|max:250',
            'fullname'  => 'required|max:250',
        ];
    }
    public function messages()
    {
        return [
            'username.required'     => 'Nhập username',
            'username.unique'       => 'Username đã tồn tại',
            'username.max'          => 'Nhập không quá 250 ký tự',
            'password.required'     => 'Nhập password',
            'password.max'          => 'Nhập không quá 250 ký tự',
            'fullname.required'     => 'Nhập fullname',
            'fullname.max'          => 'Nhập không quá 250 ký tự',
        ];
    }
}
