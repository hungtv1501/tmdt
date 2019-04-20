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
            'nameBrand.required' => ':attribute khong dc de trong',
            'nameBrand.unique' => ':attribute da ton tai',
            'address.required' => ':attribute khong dc de trong',
            'description.required' => ':attribute khong dc de trong'
          ];
    }    
}
