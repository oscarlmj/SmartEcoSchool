<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/water', 'App\Http\Controllers\echartController@water')->name("charts.water");
Route::get('/electrical', 'App\Http\Controllers\echartController@electrical')->name("charts.electrical");
Route::get('/electricalMes', 'App\Http\Controllers\echartController@electricalMes')->name("charts.electricalMes");