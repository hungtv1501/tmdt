<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Payment extends Model
{
    protected $table = 'orders';

    public function insertOrder($data)
    {
    	if (DB::table('orders')->insert($data)) {
            return true;
        }
        return false;
    }
    public function getAllDataOrder()
    {
    	$data = Payment::all();
    	if ($data) {
    		$data = $data->toArray();
    	}
    	return $data;
    }
}
