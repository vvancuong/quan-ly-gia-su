<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/hl1', function () {
    return view('frontend/home');
});

Route::get('/hl2', 'HomeController@xc');

Auth::routes(); // taoj ra cac link de dang nhap, dang ky tai khoang

Route::get('/home', 'HomeController@index')->name('home');



Route::get('admin', function () {
    return redirect('admin/monhoc'); //trang chủ trong trang quản lý
});


Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function () {

    Route::resources(['giasu' => 'GiasuController']);

    Route::resources(['monhoc' => 'MonhocController']); // xem them sua xoa

    Route::get('monhoc/page/dsmhchonv', 'MonhocController@testvvv'); // muon viet tran xam ds mon hoc rieng cho gia su cho nhan vien

    Route::resources(['phuhuynh' => 'PhuhuynhController']);

    Route::resources(['lophoc' => 'LophocController']);
});
