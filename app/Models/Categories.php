<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Categories extends Model
{
    protected $table = 'categories';

    public function products()
    {
    	return $this->belongsToMany('App\Models\Products');
    }

    public function getAllDataCategories()
    {
    	$data = Categories::all();
    	if ($data) {
    		$data = $data->toArray();
    	}
    	return $data;
    }

    public function getAllDataForKeyWord($keyword = '')
    {
        $data = Categories::select('*')
            ->where('categories.name','LIKE','%'.$keyword.'%')
            ->orWhere('categories.parent_id','LIKE','%'.$keyword.'%')
            ->paginate(3);
        return $data;
    }

    public function addData($data)
    {
        if (DB::table('categories')->insert($data)) {
            return true;
        }
        return false;
    }

    public function getInfoDataCatById($id)
    {
        $data = Categories::find($id);
        if ($data) {
            $data = $data->toArray();
        }
        return $data;
    }

    public function updateDataById($data, $id)
    {
        $up = DB::table('categories')
            ->where('id', $id)
            ->update($data);
        return $up;
    }

    public function deleteCatById($id)
    {
        $del = DB::table('categories')
            ->where('id',$id)
            ->delete();
        return $del;
    }
}
