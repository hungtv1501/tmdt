<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            // khoa la id : tu dong tang va khong am (bat dau tu 1)
            $table->string('username',60)->unique();
            // user name khong trung nhau
            // truong nay bat buoc phai nhap (mac dinh)
            $table->string('password',60);
            $table->string('email',60)->unique();
            $table->tinyInteger('role')->default(1);
            // default : gan gia tri mac dinh
            $table->tinyInteger('status')->default(0);
            $table->string('avatar',120)->nullable();
            // nullable : cho phep truong nay dc rong
            $table->string('phone',20)->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
