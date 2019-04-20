<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StoreSizePost extends FormRequest
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
        $unique = ($id) ? 'unique:sizes,letter_size,'.$id : 'unique:sizes,letter_size';
        return [
            'letterSize' => 'required|'.$unique,
            'description' => 'required'
        ];
    }
     public function messages()
    {
        return [
            'letterSize.required' => 'Tên size khong dc de trong',
            'letterSize.unique' => 'Tên size da ton tai',
            'description.required' => ':attribute khong dc de trong'
          ];
    }    
}
