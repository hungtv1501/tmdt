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
            'nameColor.required' => ':attribute khong dc de trong',
            'nameColor.unique' => ':attribute da ton tai',
            'nameColor.min' => ':attribute phai lon hon :min ki tu',
            'description.required' => ':attribute khong dc de trong'
          ];
    }     
}
