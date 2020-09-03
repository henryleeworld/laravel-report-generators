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
Route::get('report/display/csv', 'ReportController@displayCsv');
Route::get('report/display/excel', 'ReportController@displayExcel');
Route::get('report/display/pdf', 'ReportController@displayPdf');
