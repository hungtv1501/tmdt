<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class PaymentOrderPost extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'username' => 'required',
            'email' => 'required|email',
            'sdt' => 'required|max:20',
            'address' => 'required',
        ];
    }
    public function messages() {
        return [
            'username.required' => 'Tên không được để trống',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không hợp lệ',
            'sdt.required' => 'Số điện thoại không được để trống',
            'sdt.max' => 'Số điện thoại không quá :max ký tự',
            'address.required' => 'Địa chỉ không được để trống',
        ];
    }
}
