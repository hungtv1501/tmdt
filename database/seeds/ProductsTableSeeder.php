<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$strIdCat = json_encode([1,2]); // 1,2 id cua bang categories
    	// json_encode(): chuyen mang ve chuoi json (object cua JS)
    	$strIdColor = json_encode([1,5]);
    	$strIdSize = json_encode([2,4]);
    	$strImages = json_encode(['jean-001.png','jean-002.png','jean-003.png']);

        DB::table('products')->insert([
        	'name_product' => 'Quan jean Korea SDD05',
        	'id_cat' => $strIdCat,
        	'id_color' => $strIdColor,
        	'id_size' => $strIdSize,
        	'id_brand' => 2,
        	'price' => 100000,
        	'qty' => 300,
        	'description' => 'Do dep xin so cac kieu',
        	'image_product' => $strImages,
        	'sale_off' => null,
        	'status' => 1,
        	'view_product' => 0,
        	'created_at' => date('Y-m-d H:i:s'),
        	'updated_at' => null,
        ]);
    }
}
