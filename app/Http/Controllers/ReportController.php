<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Jimmyjs\ReportGenerator\Facades\CSVReportFacade as CSVReport;
use Jimmyjs\ReportGenerator\Facades\ExcelReportFacade as ExcelReport;
use Jimmyjs\ReportGenerator\Facades\PdfReportFacade as PdfReport;

class ReportController extends Controller
{
    public function displayCsv(Request $request)
    {
        $infoAry = $this->setReportInfo($request);

        return CSVReport::of($infoAry['title'], $infoAry['meta'], $infoAry['queryBuilder'], $infoAry['columns'])
               ->simple()
               ->download('filename');
    }

    public function displayExcel(Request $request)
    {
        $infoAry = $this->setReportInfo($request);

        return ExcelReport::of($infoAry['title'], $infoAry['meta'], $infoAry['queryBuilder'], $infoAry['columns'])
               ->simple()
               ->download('filename');
    }

    public function displayPdf(Request $request)
    {
        $infoAry = $this->setReportInfo($request);

        return PdfReport::of($infoAry['title'], $infoAry['meta'], $infoAry['queryBuilder'], $infoAry['columns'])
               ->simple()
               ->download('filename');
    }

    private function setReportInfo($request)
    {
        $fromDate = $request->input('from_date') ?? '2000-01-01 01:00:00';
        $toDate = $request->input('to_date') ?? '2999-12-31 23:59:59';

        $title = __('Registered users report');

        $meta = [
            __('Registration interval: ') => $fromDate . __(' to ') . $toDate
        ];

        $queryBuilder = User::select(['id', 'name', 'email', 'created_at'])
                        ->whereBetween('created_at', [$fromDate, $toDate]);

        $columns = [
            __('Name') => 'name',
            __('Email') => 'email',
            __('Created At') => 'created_at',
            __('Condition') => function($result) {
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
