<?php

use App\Http\Controllers\ReportController;
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

Route::get('report/display/csv', [ReportController::class, 'displayCsv']);
Route::get('report/display/excel', [ReportController::class, 'displayExcel']);
Route::get('report/display/pdf', [ReportController::class, 'displayPdf']);