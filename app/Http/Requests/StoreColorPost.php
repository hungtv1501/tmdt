<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StoreColorPost extends FormRequest
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
        unique:colors,name_color,'.$id : 'unique:colors,name_color';
        return [
            //
            'nameColor' => 'required|'.$unique,
            'description' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'nameColor.required' => 'Tên màu không được để trống',
            'nameColor.unique' => 'Tên màu đã bị trùng',
            'nameColor.min' => 'Tên màu phải lớn hơn :min ký tự',
            'description.required' => 'Mô tả không được để trống'
          ];
    }     
}
