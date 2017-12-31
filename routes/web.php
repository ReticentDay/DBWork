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

Auth::routes();

Route::get('/nothing',function(){
    return 'nothing in here';
});

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/user/type', 'UserController@typeUpdate');
Route::get('/user/type', 'UserController@typeList');
Route::get('/user/type/serch/{keyWord}', 'UserController@typeListSerch');
Route::resource('user', 'UserController');

Route::get('/shop/list','ShopController@list');
Route::post('/shop/add','ShopController@add');
Route::get('/shop/order','ShopController@order');
Route::post('/shop/order/over','ShopController@orderover');
Route::get('/shop/serch/{key}', 'ShopController@search');
Route::get('/shop/serch/{id}', 'DiscountController@search');
Route::get('/shop/serch', 'ShopController@searchs');
Route::resource('shop', 'ShopController');
Route::resource('discount', 'DiscountController');

Route::get('/product/serch/', 'ProductController@search');
Route::resource('product', 'ProductController');

Route::get('/money', 'OtherController@money');