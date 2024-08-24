<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Jimmyjs\ReportGenerator\Facades\PdfReportFacade as PdfReport;
use Jimmyjs\ReportGenerator\Facades\ExcelReportFacade as ExcelReport;
use Jimmyjs\ReportGenerator\Facades\CSVReportFacade as CSVReport;

class ReportController extends Controller
{
    public function displayCsv(Request $request)
    {
        $infoAry = $this->setReportInfo($request);

        // Generate Report with flexibility to manipulate column class even manipulate column value (using Carbon, etc).
        return CSVReport::of($infoAry['title'], $infoAry['meta'], $infoAry['queryBuilder'], $infoAry['columns'])
               ->simple()
               ->download('filename');
    }

    public function displayExcel(Request $request)
    {
        $infoAry = $this->setReportInfo($request);

        // Generate Report with flexibility to manipulate column class even manipulate column value (using Carbon, etc).
        return ExcelReport::of($infoAry['title'], $infoAry['meta'], $infoAry['queryBuilder'], $infoAry['columns'])
               ->simple()
               ->download('filename');
    }

    public function displayPdf(Request $request)
    {
        $infoAry = $this->setReportInfo($request);

        // Generate Report with flexibility to manipulate column class even manipulate column value (using Carbon, etc).
        return PdfReport::of($infoAry['title'], $infoAry['meta'], $infoAry['queryBuilder'], $infoAry['columns'])
               ->simple()
               ->download('filename');
    }

    private function setReportInfo($request)
    {
        $fromDate = $request->input('from_date') ?? '2000-01-01 01:00:00';
        $toDate = $request->input('to_date') ?? '2999-12-31 23:59:59';

        $title = __('Registered users report'); // Report title

        $meta = [ // For displaying filters description on header
            __('Registration interval: ') => $fromDate . __(' to ') . $toDate
        ];

        $queryBuilder = User::select(['id', 'name', 'email', 'created_at']) // Do some querying..
                        ->whereBetween('created_at', [$fromDate, $toDate]);

        $columns = [ // Set Column to be displayed
            __('Name') => 'name',
            __('Email') => 'email',
            __('Created At') => 'created_at', // if no column_name specified, this will automatically seach for snake_case of column name (will be registered_at) column from query result
            __('Condition') => function($result) { // You can do if statement or any action do you want inside this closure
                return ((int)$result->id > 10) ? '' : __('Top ten registration');
            }
        ];
        return [
            'title'        => $title,
            'meta'         => $meta,
            'queryBuilder' => $queryBuilder,
            'columns'      => $columns
        ];
    }
}
