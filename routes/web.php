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


Route::namespace('Admin')->group(function () {

    Route::get('/', 'IndexController@index')->name('index.index')->middleware('login.auth');
    Route::get('/login', 'IndexController@login')->name('index.login');
    Route::get('/logout', 'IndexController@logout')->name('index.logout');
    Route::post('/verifyLogin', 'IndexController@verifyLogin')->name('index.verifyLogin');
    Route::get('/main', 'IndexController@main')->name('index.main')->middleware('login.auth');;

    //menu
    Route::group(['prefix' => 'menu','middleware' => ['login.auth']], function () {
        Route::get('/index', 'MenuController@index')->name('menu.index')->middleware('access.route'); //index
        Route::post('/create', 'MenuController@store')->name('menu.create');
        Route::post('/find', 'MenuController@find')->name('menu.find');
        Route::post('/del', 'MenuController@destroy')->name('menu.del');
    });

    //role
    Route::group(['prefix' => 'role','middleware' => ['login.auth']], function () {
        Route::get('/index', 'RoleController@index')->name('role.index')->middleware('access.route'); //index;
        Route::match(['get','post'], '/create', 'RoleController@store')->name('role.create');
        Route::get('/find/{id}', 'RoleController@find')->name('role.find');
        Route::post('/del', 'RoleController@destroy')->name('role.del');
    });

    //account
    Route::group(['prefix' => 'account','middleware' => ['login.auth']], function () {
        Route::get('/index', 'AccountController@index')->name('account.index')->middleware('access.route'); //index;
        Route::post('/create', 'AccountController@store')->name('account.create');
        Route::post('/find', 'AccountController@find')->name('account.find');
        Route::post('/del', 'AccountController@destroy')->name('account.del');
    });

    //home
    Route::group(['prefix' => 'home','middleware' => ['login.auth']], function () {
        Route::get('/index', 'HomeController@index')->name('home.index'); //index;
        Route::post('/create', 'HomeController@store')->name('home.create');
        Route::post('/find', 'HomeController@find')->name('home.find');
        Route::post('/del', 'HomeController@destroy')->name('home.del');
    });

    //category
    Route::group(['prefix' => 'category','middleware' => ['login.auth']], function () {
        Route::get('/index', 'CategoryController@index')->name('category.index'); //index;
        Route::post('/create', 'CategoryController@store')->name('category.create');
        Route::post('/find', 'CategoryController@find')->name('category.find');
        Route::post('/del', 'CategoryController@destroy')->name('category.del');
        Route::post('/upload', 'CategoryController@upload')->name('category.upload');
    });

    //Product
    Route::group(['prefix' => 'product','middleware' => ['login.auth']], function () {
        Route::get('/index', 'ProductController@index')->name('product.index'); //index;
        Route::post('/create', 'ProductController@store')->name('product.create');
        Route::get('/find', 'ProductController@find')->name('product.find');
        Route::post('/del', 'ProductController@destroy')->name('product.del');
        Route::post('/upload', 'ProductController@upload')->name('product.upload');
        Route::post('/mulitupload', 'ProductController@mulitUpload')->name('product.mulitupload');
        Route::get('/cover', 'ProductController@cover')->name('product.cover');
        Route::post('/preview', 'ProductController@preview')->name('product.preview');
        Route::post('/removeCover', 'ProductController@removeCover')->name('product.removeCover');
    });

    //banner
    Route::group(['prefix' => 'banner','middleware' => ['login.auth']], function () {
        Route::get('/index', 'BannerController@index')->name('banner.index'); //index;
        Route::post('/create', 'BannerController@store')->name('banner.create');
        Route::post('/find', 'BannerController@find')->name('banner.find');
        Route::post('/del', 'BannerController@destroy')->name('banner.del');
        Route::post('/upload', 'BannerController@upload')->name('banner.upload');
    });


});


