<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'phone'         => 'required',
            'address'       => 'required',

        ];
    }
    public function messages()
    {
        return [
            'fullname.required' => 'Nhập đầy đủ Họ Tên',
            'phone.required'    => 'Nhập vào Số điện thoại',
            'address.required'  => 'Nhập địa chỉ Nhà',
        ];
    }
}
