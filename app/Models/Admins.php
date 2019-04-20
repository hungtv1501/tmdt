<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Admins extends Model
{
    
    //quy uoc file model nay lam viec voi bang du lieu nao
    // 1 file model chi lam viec tuong ung voi 1 bang du lieu
    protected $table = 'admins';

    // vi no la table nen chung ta se viet cac ham truy van du lieu

    public static function getAllDataAdmins()
    {
    	$data = Admins::all();
    	// get() : Query builder
    	// all() : ORM;
    	if ($data) {
    		// truoc khi chuyen ve Array kiem tra xem no co rong hay ko
    		$data = $data->toArray();
    	}
    	else
    		$data = [];
    	return $data;
    }

    public function getDataAdminById($id)
    {
    	// DB::table('admins')
    	// ->where('id',$id)
    	// ->first();

    	$info = Admins::find($id);
    	return $info;
    }

    public function getDataAdminByConditions($keyword = null)
    {
    	$data = [];
    	$query = Admins::select('id','username','email')
    		->where('username','like','%'.$keyword.'%')
    		->orWhere('email','like','%'.$keyword.'%')
    		->get();
    	if ($query) {
    		# code...
    		$data = $query->toArray();
    	}
    	else 
    		$data = [];
    	return $data;
    }

    public function checkAdminLogin($user, $pass)
    {
        $data = [];
        $query = Admins::select('*')
                        ->where('username',$user)
                        ->where('password',$pass)
                        ->where('role',-1)
                        ->where('status',1)
                        ->first();
        if ($query) {
            $data = $query->toArray();
        }
        return $data;
    }
}
