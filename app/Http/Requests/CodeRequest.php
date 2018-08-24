<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CodeRequest extends FormRequest
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
            'macode'                => 'required|unique:code',
            'value'                 => 'required',
            'don_hang_toi_thieu'    => 'required',
        ];
    }
    public function messages()
    {
        return [
            'macode.required'     => 'Nhập Mã Code',
            'macode.unique'       => 'Mã Code đã tồn tại',
            'value.required'     => 'Nhập Giá Trị',
            'don_hang_toi_thieu.required'     => 'Nhập Đơn hàng tối thiểu',
        ];
    }
}
