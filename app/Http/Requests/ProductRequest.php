<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name'      => 'required',
            'price_old' => 'required|integer',
            'detail'    => 'required',
            'preview'   => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required'         => 'Thêm vào Tên Sản Phẩm',
            'price_old.required'    => 'Thêm giá cho sản phẩm',
            'price_old.integer'     => 'Giá cho sản phẩm là số Nguyên dương',
            'preview.required'      => 'Thêm Mô tả cho sản phẩm',
            'detail.required'       => 'Thêm nội dung cho sản phẩm'
        ];
    }
}
