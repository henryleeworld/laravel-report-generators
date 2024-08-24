<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('report/display/csv', [ReportController::class, 'displayCsv']);
Route::get('report/display/excel', [ReportController::class, 'displayExcel']);
Route::get('report/display/pdf', [ReportController::class, 'displayPdf']);
