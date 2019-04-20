<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sizes extends Model
{
    protected $table = 'sizes';

    public function products()
    {
    	return $this->belongsToMany('App\Models\Products');
    }

    public function getAllDataSizes()
    {
    	$data = Sizes::all();
    	if ($data) {
    		$data = $data->toArray();
    	}
    	return $data;
    }

    public function getInfoSizeById($arrId = [])
    {
        $data = Sizes::select('*')
            ->whereIn('id',$arrId)
            ->get();
        if ($data) {
            $data = $data->toArray();
        }
        return $data;
    }

    public function addDataSize($data){
        if(DB::table('sizes')->insert($data)){
            return true;
        }
        return false;
    }

    public function getInfoDataSizeById($id){
        $data= Sizes::find($id);
        if($data){
            $data = $data->toArray();

        }
        return $data;
    }
     public function updateDataSizeById($data, $id)
    {
        $up = DB::table('sizes')
                    ->where('id',$id)
                    ->update($data);
        return $up;
    }
     public function deleteSizeById($id)
    {
        $del = DB::table('sizes')
                   ->where('id',$id)
                   ->delete();
        return $del;
    }
    public function getAllDataKeySize($keyword = '')
    {
        $data = sizes::select('*')
                ->where('letter_size','LIKE','%'.$keyword.'%')
                ->paginate(4);
        // if($data){
        //     $data = $data->toArray();
        // }
        return $data;
    }
}
