<?php

namespace App\Http\Controllers;

use App\Models\QRData;
use Log;
use App\Models\User;
use Illuminate\Bus\Events\BatchDispatched;
use Illuminate\Http\Request;
use App\Models\ProductivityReport;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SupervisorController extends Controller
{

    public function ScanQR()
    {
        return view('Supervisor.scan');
    }


    public function UpdateDispatchStatus(Request $request)
    {

        try {
            // Find the QRData model by ID
            $qrData = QRData::findOrFail($request->id);

            // Check if the current dispatch_status is already 'Dispatched'
            $alreadyDispatched = $qrData->dispatch_status === 'Dispatched';

            // Update the model with the validated data if not already dispatched
            if (!$alreadyDispatched) {
                $qrData->update(['dispatch_status' => 'Dispatched']);
            }

            // Return the updated data as a JSON response
            return response()->json([
                'success' => true,
                'flag' => $alreadyDispatched ? 'Already Dispatched' : 'success',
                'data' => $qrData
            ]);
        } catch (\Exception $e) {
            // Log the error and return a JSON response with an error message
            return response()->json([
                'success' => false,
                'flag' => 'Please Try again!',
                'data' => null
            ]);
        }
    }

    public function UpdatetrollyStatus(Request $request)
    {
        $data = $request->validate([
            'trolly_name' => 'required|string',
            'supervisor' => 'required|string',
            'department' => 'required|string'
        ]);



        $newRecord = [
            'trolly_name' => $data['trolly_name'],
            'supervisor' => $data['supervisor'],
            'department' => $data['department'],
            'entry_time' => Carbon::now(),
        ];

        $latestReport = ProductivityReport::where('trolly_name', $newRecord['trolly_name'])->latest()->first();

        if ($latestReport && !$latestReport->exit_time) {
            $exitTime = Carbon::now();
            $entryTime = new Carbon($latestReport->entry_time);
            $totalTime = $entryTime->diff($exitTime)->format('%H:%I:%S');

            $latestReport->update([
                'exit_time' => $exitTime,
                'total_time' => $totalTime,
            ]);
        }


        ProductivityReport::create($newRecord);

        return response()->json(['message' => 'Data stored successfully']);
    }
}
