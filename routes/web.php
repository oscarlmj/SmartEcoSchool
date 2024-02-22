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

Route::get('/', 'App\Http\Controllers\indexController@index')->name("layouts.index");

Route::get('/water', 'App\Http\Controllers\echartController@waterWeek')->name("charts.water");
Route::get('/watermonth', 'App\Http\Controllers\echartController@waterMonth')->name("charts.waterMonth");

Route::get('/electrical', 'App\Http\Controllers\echartController@electrical')->name("charts.electrical");
Route::get('/electricalMes', 'App\Http\Controllers\echartController@electricalMes')->name("charts.electricalMes");
