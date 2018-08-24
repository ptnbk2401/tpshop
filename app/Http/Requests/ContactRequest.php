<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'fullname'      => 'required',
            'email'         => 'required|email',
            'message'       => 'required',

        ];
    }
    public function messages()
    {
        return [
            'fullname.required' => 'Nhập Họ Tên',
            'email.required'    => 'Nhập vào Email',
            'email.email'       => 'Chưa đúng định dạng Email',
            'message.required'  => 'Thêm Nội dung',
        ];
    }
}
