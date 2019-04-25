<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Products extends Model
{
    protected $table = 'products';

    public function brands() // tao moi quan he one to many voi brands
    {
    	return $this->belongsTo('App\Models\Brands');
    }

    public function categories()
    {
    	return $this->belongsToMany('App\Models\Categories');
    }

    public function colors()
    {
    	return $this->belongsToMany('App\Models\Colors');
    }

    public function sizes()
    {
    	return $this->belongsToMany('App\Models\Sizes');
    }

    public function addData($data)
    {
        if (DB::table('products')->insert($data)) {
            return true;
        }
        return false;
    }

    public function getAllData($keyword = '')
    {
        $data = Products::select('products.*','brands.brand_name')
                    ->join('brands','brands.id','=','products.brands_id')
                    ->where('products.name_product','LIKE','%'.$keyword.'%')
                    ->orWhere('products.price','LIKE','%'.$keyword.'%')
                    ->paginate(3);
        // if ($data) {
        //     $data = $data->toArray();
        // }
        return $data;
    }

    public function deleteProductById($id)
    {
        $del = DB::table('products')
            ->where('id',$id)
            ->delete();
        return $del;
    }

    public function getInfoDataProductById($id)
    {   
        $data = Products::select('products.*','brands.brand_name')
                    ->join('brands','brands.id','=','products.brands_id')
                    ->where('products.id',$id)
                    ->first();
        if ($data) {
            $data = $data->toArray();
        }
        return $data;
    }

    public function updateDataById($data, $id)
    {
        $up = DB::table('products')
            ->where('id', $id)
            ->update($data);
        return $up;
    }

    public function getFullData()
    {
        $data = Products::select('*')->get();
        return $data;
    }

    public function getDataPdForUser()
    {
        $data = Products::select('*')
            ->paginate(6);
        return $data;
    }
}
