<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // cho phep tao khoa ngoai
        Schema::enableForeignKeyConstraints();

        Schema::create('products', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name_product',150)->unique();
            $table->integer('id_cat')->unsigned();
            $table->integer('id_color')->unsigned();
            $table->integer('id_size')->unsigned();
            $table->integer('id_brand')->unsigned();
            $table->integer('price');
            $table->integer('qty');
            $table->text('description');
            $table->string('image_product',150);
            $table->string('sale_off',150)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->integer('view_product')->default(0);
            $table->timestamps();

            // rang buoc moi quan he voi bang brand
            $table->foreign('id_brand')
                ->references('id')->on('brands')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('products');
    }
}
