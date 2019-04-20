<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StoreProductPost extends FormRequest
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
        $id = $request->id;
        $unique = ($id) ? 'unique:products,name_product,'.$id : 'unique:products,name_product';
        $img = ($id) ? '' : 'required';
        return [
            // 'không được null | không được trùng: bảng product,trường name_product | it nhat 3 ky tu'
            'nameProduct' => 'required|'.$unique.'|min:3',
            'categories' => 'required',
            'color' => 'required',
            'size' => 'required',
            'brand' => 'required|numeric',
            'price' => 'required|numeric',
            'qty' => 'required|numeric',
            'image' => $img,
            'des' => 'required',
        ];
    }

    // thông báo lỗi ra ngoài view
    public function messages()
    {
        return [
            'nameProduct.required' => ':attribute khong duoc trong',
            'nameProduct.unique' => ':attribute da ton tai',
            'nameProduct.min' => ':attribute phai lon hon :min ky tu',
            'categories.required' => ':attribute khong duoc trong',
            'color.required' => ':attribute khong duoc trong',
            'size.required' => ':attribute khong duoc trong',
            'brand.required' => ':attribute khong duoc trong',
            'brand.numeric' => ':attribute phai la so',
            'price.required' => ':attribute khong duoc trong',
            'price.numeric' => ':attribute phai la so',
            'qty.required' => ':attribute khong duoc trong',
            'qty.numeric' => ':attribute phai la so',
            'image.required' => ':attribute khong duoc trong',
            'des.required' => ':attribute khong duoc trong',
        ];
    }
}
