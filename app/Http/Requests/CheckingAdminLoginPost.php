<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckingAdminLoginPost extends FormRequest
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
    public function rules() // nơi thiết lập các quy tắc hay các luật validation các dữ liệu từ form gửi lên 
    {
        return [
            'username'=>'required|min:3|max:60',
            'password' =>'required|min:3|max:60'
        ];
    }
    public function messages()
    {
        // thông báo lỗi ra ngoài form
        return [
            'username.required'=>':attribute không được để trống',
            'username.min'=>'tên tài khoản không được nhỏ hơn :min ký tự',
            'username.max'=>':attribute không được lớn hơn :max ký tự',
            'password.required'=>':attribute không được để trống',
            'password.min'=>'Password không được nhỏ hơn :min ký tự',
            'password.max'=>':attribute không được lớn hơn :max ký tự',
        ];
    }
}