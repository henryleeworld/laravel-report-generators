<?php

namespace App\Http\Controllers;

use App\User;
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

        $title = '註冊使用者報告'; // Report title

        $meta = [ // For displaying filters description on header
            '註冊區間：' => $fromDate . ' 到 ' . $toDate
        ];

        $queryBuilder = User::select(['id', 'name', 'email', 'created_at']) // Do some querying..
                        ->whereBetween('created_at', [$fromDate, $toDate]);

        $columns = [ // Set Column to be displayed
            '名稱' => 'name',
            '電子郵件' => 'email',
            '建立時間' => 'created_at', // if no column_name specified, this will automatically seach for snake_case of column name (will be registered_at) column from query result
            '狀態' => function($result) { // You can do if statement or any action do you want inside this closure
                return ((int)$result->id > 10) ? '' : '前十名註冊';
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
