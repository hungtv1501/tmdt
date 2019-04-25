<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StoreBrandPost extends FormRequest
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
        $id= $request->id;
        $unique = ($id) ? '
        unique:brands,brand_name,'.$id : 'unique:brands,brand_name';
        return [
            //
            'nameBrand' => 'required|'.$unique,
            'address'=>'required',
            'description' => 'required'
        ];
    }
     public function messages()
    {
        return [
            'nameBrand.required' => 'Tên thương hiệu không được để trống',
            'nameBrand.unique' => 'Tên thương hiệu đã tồn tại',
            'address.required' => 'Địa chỉ thương hiệu không được để trống',
            'description.required' => 'Mô tả thương hiệu không được để trống'
          ];
    }    
}
