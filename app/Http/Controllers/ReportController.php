<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exports\QRReportExport;


class ReportController extends Controller
{
    //
    public function QRCodeReportDownload(Request $request)
    {
        // return $request;
        if ($request->date_range != null)
        {
            $dateRange = $_GET['date_range'];

            list($startDate, $endDate) = explode(' - ', $dateRange);

            $_START = Carbon::createFromFormat('m/d/Y', $startDate)->toDateString();
            $_END = Carbon::createFromFormat('m/d/Y', $startDate)->toDateString();

            $fromDate = Carbon::createFromFormat('m/d/Y', $startDate)->startOfDay();
            $toDate = Carbon::createFromFormat('m/d/Y', $endDate)->endOfDay();

            $fromDate = $fromDate->toDateTimeString();
            $toDate = $toDate->toDateTimeString();
        }
        else{
            return redirect()->back()->with('error', 'Please select a date range');
        }


        return (new QRReportExport($fromDate, $toDate))
                ->download('QR_Report_Export ' .$_START. ' - ' .$_END. '.csv');

    }
}
