<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Colors extends Model
{
    protected $table = 'colors';

    public function getInfoColorByArrId($arrId = [])
    {
        $data = Colors::select('*')
                      ->whereIn('id',$arrId)
                      ->get();
        if($data){
            $data = $data->toArray();
        }
        return $data;
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Products');
    }
    /*
    public function testManyToMany()
    {
        $data = Colors::find(1)
                    ->products() 
        $data = Colors::with('products')->get();

        if($data){
            $data = $data->toArray();
        }
        return $data;
    }
    */
     public function addDataColor($data)
    {
        if(DB::table('colors')->insert($data)){
            return true;
        }  
        return false;
    }
   
    public function getAllDataColors()
    {
        $data = Colors::all();
        if($data){
            $data = $data->toArray();
        }
        return $data;
    }
     public function getInfoDataColorById($id)
    {
        $data = Colors::find($id);
        if($data){
            $data = $data->toArray();
        }
        return $data;
    }
    public function updateDataColorById($data, $id)
    {
        $up = DB::table('colors')
                    ->where('id',$id)
                    ->update($data);
        return $up;
    }
    public function deleteColorById($id)
    {
        $del = DB::table('colors')
                   ->where('id',$id)
                   ->delete();
        return $del;
    }
    public function getAllDataKeyColors($keyword = '')
    {
        $data = Colors::select('*')
                ->where('name_color','LIKE','%'.$keyword.'%')
                ->paginate(3);
        // if($data){
        //     $data = $data->toArray();
        // }
        return $data;
    }
}
