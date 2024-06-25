<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductivityReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ProductivityReportController extends Controller
{
    public function ScanTrollyQR()
    {
        return view('Supervisor.scan-trolly');
    }
    // public function store(Request $request)
    // {
    //     $trollyName = $request->input('trolly_name');
    //     $department = Auth::user()->department;
    //     $supervisor = Auth::user()->name;

    //     $latestReport = ProductivityReport::where('trolly_name', $trollyName)->latest()->first();

    //     if ($latestReport && !$latestReport->exit_time) {
    //         $exitTime = Carbon::now();
    //         $entryTime = new Carbon($latestReport->entry_time);
    //         $totalTime = $entryTime->diff($exitTime)->format('%H:%I:%S');

    //         $latestReport->update([
    //             'exit_time' => $exitTime,
    //             'total_time' => $totalTime,
    //         ]);
    //     }

    //     ProductivityReport::create([
    //         'trolly_name' => $trollyName,
    //         'department' => $department,
    //         'supervisor' => $supervisor,
    //         'entry_time' => Carbon::now(),
    //     ]);

    //     return response()->json(['message' => 'Data stored successfully']);
    // }

}
