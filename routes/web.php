<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello',function(){
	return 'Hello word';
});

Route::get('/hi-you',function(){
	return "This is valentine day !";
});

/************** method GET  ******************/
Route::get('/test',function(){
	return "This is test";
});
// /test : request cua nguoi dung gui len
// ::get() : phuong thuc gui du lieu
// return "This is test"; : respone tra ket qua ve

/****** method POST ****************/
Route::post('/demo-post',function(){
	return "This is method post";
});

/***** method DELETE ***********/
Route::delete('/demo-delete', function(){
	return "This is method delete";
});

/******* method PUT ************/
Route::put('/method-put',function(){
	return "This is method PUT";
});

// chap moi phuong thuc cho 1 request
Route::any('/demo-any',function(){
	return "This is method ANY";
});

// chap nhan 1 hoac nhieu phuong thuc cho 1 request
Route::match(['get','post','put'],'/all-in-one',function(){
	return "This is match Routes";
});

Route::get('/quynh-bup-be-t1',function(){
	// dieu huong trang
	// header('Location:domain')
	return redirect('nguoi-phan-xu-t1');
});

Route::get('/nguoi-phan-xu-t1',function(){
	return "nguoi phan xu tap 1";
})->name('npx');

Route::get('/film-superman',function(){
	// dieu huong trang
	// header('Location:domain')
	return redirect()->route('npx');
});

// route view
Route::get('/demo-view',function(){
	return view('demo');
});

// truyen tham so vao router
// tham so bat buoc - phai truyen vao request khi gui du lieu len server
Route::get('/sam-sung/{name}/{price}',function($namePhone,$pricePhone){
	return "ban dang xem dien thoai {$namePhone} - gia ban la : {$pricePhone}";
});
// tham so khong bat buoc
Route::get('/apple/{name?}/{price?}',function($name = null, $price = null){
	return "Ban dang xem dien thoai iphone : {$name} - Gia ban la : {$price}";
});
// validate tham so routes

// tuoi chi duoc phep nhap so
// ten chi la cac chu cai
Route::get('/check-age/{age}/{name}',function($age,$name){
	return "my age is {$age} - my name  is {$name}";
})->where(['age'=>'[0-9]+','name' => '[A-Za-z]+']);

// name routes
Route::get('/home-page-1',function(){
	return view('home-page');
})->name('homePage');

Route::get('/contact-page',function(){
	return "This is contact page";
})->name('contactPage');

// routes group
Route::group([
	'prefix' => 'admin',
	'as' => 'admin.'
],function(){

	Route::get('/home',function(){
		return "admin - home";
	})->name('home');

	Route::get('/product',function(){
		return "admin - Product";
	})->name('product');
});

Route::get('/login',function(){
	return redirect()->route('admin.home');
});

Route::get('/watch-film/{age}',function($age){
	return redirect()->route('qbb');
})->name('watchFilm')
  ->where('age','[0-9]+')
  ->middleware('myCheckAge');

Route::get('/quynh-bup-be-t10',function(){
	return "chuc ban xem phim vui ve";
})->name('qbb');

Route::get('do-not-watch-film',function(){
	return "ban chua du tuoi de vao xem";
})->name('cancleFilm');

Route::get('/kt-snt/{number}',function($num){

});

Route::get('/result-ok',function(){
	return "OK";
});

Route::get('/result-fail',function(){
	return "Fail";
});

Route::get('demo-controller','DemoController@index');

Route::get('/demo-home/{name}/{age}','DemoController@test')->name('test-controlelr');
Route::get('demo-view','TestController@index');
Route::post('demo-login','TestController@login')->name('loginForm');













