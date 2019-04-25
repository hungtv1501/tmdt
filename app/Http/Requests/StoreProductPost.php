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
            'brand' => 'required',
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
            'nameProduct.required' => 'Tên sản phẩm không được để trống',
            'nameProduct.unique' => 'Tên sản phẩm đã tồn tại',
            'nameProduct.min' => 'Tên sản phẩm phải lớn hơn :min ký tự',
            'categories.required' => 'Danh mục không được để trống',
            'color.required' => 'Màu sắc không được để trống',
            'size.required' => 'Kích cỡ không được để trống',
            'brand.required' => 'Thương hiệu không được để trống',
            'price.required' => 'Đơn giá không được để trống',
            'price.numeric' => 'Đơn giá phải là số',
            'qty.required' => 'Số lượng sản phẩm không được để trống',
            'qty.numeric' => 'Số lượng phải là số',
            'image.required' => 'Hình ảnh sản phẩm không được để trống',
            'des.required' => 'Mô tả sản phẩm không được để trống',
        ];
    }
}
