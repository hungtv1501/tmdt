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
            'sdt' => 'required',
            'address' => 'required',
        ];
    }
    public function messages() {
        return [
            'username.required' => ':attribute không được để trống',
            'email.required' => ':attribute không được để trống',
            'email.email' => ':attribute không hợp lệ',
            'sdt.required' => ':attribute không được để trống',
            'address.required' => ':attribute không được để trống',
        ];
    }
}
