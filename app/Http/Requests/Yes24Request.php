<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Yes24Request extends FormRequest
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
            'idcat'  => 'required',
            'link'      => 'required|url',
        ];
    }
    public function messages()
    {
        return [
            'idcat.required'     => 'Chọn Danh Mục',
            'link.required'         => 'Thêm Link cho Danh mục',
            'link.url'              => 'Chưa đúng định dạng URL'
        ];
    }
}
