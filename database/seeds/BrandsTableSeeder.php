<?php

use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->insert([
        	'brand_name' => 'Blanciaga',
        	'address' => 'ABC',
        	'status' => 1,
        	'description' => 'Khong co dia chi',
        	'created_at' => date('Y-m-d H:i:s'),
        	'updated_at' => null,
        ]);
    }
}
