<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Admins;
use App\Models\Brands;
use App\Models\Colors;


class TestQueryBuilderController extends Controller
{
    public function index()
    {
    	// thuc thi cau lenh query data o day
    	// SELECT * FROM admins;
    	$data = DB::table('admins')->get(); // query builder: truy van CSDL theo php
    	// data la 1 object chu KO phai la 1 mang
    	//  chuyen object ve mang
    	$data = json_decode($data,true);
    	foreach ($data as $key => $value) {
    		# code...
    		// echo $value->id;
    		//echo $value['id'];
    		//echo "<br>";
    	}
    	$data2 = DB::table('products AS a')
    			->select('a.id','a.name_product AS name','a.price')
    			->get(); // get === fetchAll
    	// SELECT a.id, a.name_product AS name, a.price FROM products AS a
    	// dd($data2);

    	// SELECT a.id, a.name_product AS name, a.price FROM products AS a WHERE a.id = 2 AND name = abac AND qty = 1 OR price > 1000 OR status = 1
    	$data3 = DB::table('products AS a')
    			->select('a.id','a.name_product AS name','a.price')
    			// ->where('a.id',2)
    			// ->where('a.name_product','Quan jean Korea SDD04')
    			// ->where('a.qty',1)
    			->where([
    				'a.id' => 2,
    				'a.name_product' => 'Quan jean Korea SDD04',
    				'a.qty' => 1,
    					])
    			->orWhere('a.price','>',10000)
    			->orWhere('a.status',1)
    			->first();
    	// dd($data3);
    	// max - min - avg
    	// SELECT MAX('price') FROM products
		// SELECT MIN('price') FROM products
		// SELECT AVG('price') FROM products
    	$price = DB::table('categories')->avg('id');
    	// dd($price);

    	// SELECT count(id) FROM brands
    	$count = DB::table('brands')->count();
    	// dd($count);

    	// JOIN trong laravel
    	// san pham co id la 1 thuoc nhan hang nao
    	// SELECT a.id, a.name_brand FROM products AS a
    	// JOIN bands AS b ON a.id_brand = b.id
    	// WHERE a.id = 1
    	$data4 = DB::table('products AS a')
    		->select('a.id AS idProduct','b.brand_name')
    		->join('brands AS b','a.id_brand','=','b.id')
    		->where('a.id',1)
    		->first();
    		// dd($data4);

    	//SELECT name, price FROM products
    	$data5 = DB::table('products')
    	->select('id','name_product')
		->where('name_product','like','%04%')
		->get();
		// dd($data5);

		// INSERT INTO product('name_product','price') VALUES('asd','ajsgdj')
		// $insert = DB::table('colors')
		// 	->insert([
		// 		'name_color' => 'Luc',
		// 		'status' => 1,
		// 		'description' => 'Mau luc',
		// 		'created_at' => date('Y-m-d H:i:s'),
		// 		'updated_at' => null,
		// 	]);
		// if ($insert) {
		// 	# code...
		// 	echo "OK";
		// }
		// else echo "NO";

		// UPDATE 'colors' SET name_color = 'violet' WHERE id = 6
		// $update = DB::table('colors')
		// 	->where('id',1)
		// 	->update([
		// 		'name_color' => 'Xam',
		// 		'description' => 'Mau xam',
		// 	]);
		// if ($update) {
		// 	# code...
		// 	echo "OK";
		// }
		// else echo "FAIL";

		// DELETE FROM colors WHERE id = 6
		$delete = DB::table('colors')
			->where('id',6)
			->delete();
		if ($delete) {
			# code...
			echo "OK";
		}
		else echo "FAIL";
    }
    public function orm(Admins $admin)
    {
    	$data = Admins::getAllDataAdmins();
    	// echo "<pre>";
    	// print_r($data);
    	// dd($data);

    	// lay du lieu tu ham
    	$info = $admin->getDataAdminById(2);
    	// $data1 = $info->getDataAdminById(2);
    	// echo $data1;
    	// dd($info['id']);
    	// foreach ($data as $key => $value) {
    	// 	# code...
    	// 	echo $value['id'];
    	// 	echo "<br>";
    	// }

    	$query = $admin->getDataAdminByConditions('yx');
    	dd($query);
    }

    public function oneToMany(Brands $brands)
    {
        $data = $brands->TestOneToMany();
        dd($data->toArray());
    }
    // public function manyToMany(Colors $colors)
    // {
    //     $data = $colors->testManyToMany();
    //     dd($data);
    // }
}
