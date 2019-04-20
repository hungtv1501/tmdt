<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Brands extends Model
{
    // chi dinh file model nay lam viec voi bang du lieu nao
    protected $table = 'brands';

    // tao phuong thuc de lien ket quan he voi model khac
    public function products()
    {
        // y dinh : phuong thuc se lien ket quan he one - to - many voi bang product
        return $this->hasMany('App\Models\Products');
    }

    public function testOneToMany()
    {
        return Brands::find(1)->products;
    }

    public function getAllDataBrands()
    {
        $data = Brands::all();
        if($data){
            $data = $data->toArray();
        }
        return $data;
    }
    public function addDataBrand($data)
    {
        if(DB::table('brands')->insert($data)){
            return true;
        }  
        return false;
    }
     public function getInfoDataBrandById($id)
    {
        $data = Brands::find($id);
        if($data){
            $data = $data->toArray();
        }
        return $data;
    }
     public function updateDataBrandById($data, $id)
    {
        $up = DB::table('brands')
                    ->where('id',$id)
                    ->update($data);
        return $up;
    }
     public function deleteBrandById($id)
    {
        $del = DB::table('brands')
                   ->where('id',$id)
                   ->delete();
        return $del;
    }
    public function getAllDataKeyBrands($keyword = '')
    {
        $data = Brands::select('*')
                ->where('brand_name','LIKE','%'.$keyword.'%')
                ->paginate(3);
        // if($data){
        //     $data = $data->toArray();
        // }
        return $data;
    }
}
