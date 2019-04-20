<?php

use Illuminate\Database\Seeder;

class SizesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sizes')->insert([
        	'letter_size' => 'XXL',
        	'number_size' => null,
        	'status' => 1,
        	'description' => 'size danh cho nguoi sieu chuan',
        	'created_at' => date('Y-m-d H:i:s'),
        	'updated_at' => null,
        ]);
    }
}
