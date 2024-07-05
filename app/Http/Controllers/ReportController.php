<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exports\QRReportExport;


class ReportController extends Controller
{
    public function QRCodeReportDownload(Request $request)
    {
        // return $request;
        $dispatchStatus = $request->status ?? '';

        $grade_name = $origin = $dispatch_status =null;
        if($request->grade_name != null){
           $grade_name = $request->grade_name;
        }
        if($request->origin != null){
            $origin = $request->origin;
        }
        if($request->dispatch_status != null){
            $dispatch_status = $request->dispatch_status;
         }
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


        return (new QRReportExport($fromDate, $toDate, $grade_name, $origin, $dispatchStatus))
                ->download('QR_Report_Export ' .$_START. ' - ' .$_END. '.csv');

    }
}
