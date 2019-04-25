<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request; 

class StoreCatPost extends FormRequest
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
        $unique = ($id) ? 'unique:categories,name,'.$id : 'unique:categories,name';
        return [
            'nameCat' => 'required|'.$unique.'|min:3',
            'cat_parent' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nameCat.required' => 'Tên danh mục không được để trống',
            'nameCat.unique' => 'Tên danh mục đã tồn tại',
            'cat_parent.required' => 'Danh mục cha không được để trống',
            'namCat.min' => 'Tên danh mục phải lớn hơn :min ký tự',
        ];
    }
}
