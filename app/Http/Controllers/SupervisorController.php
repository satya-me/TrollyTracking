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
        // return $request->supervisor_id;
        try {
            // Find the QRData model by ID
            $qrData = QRData::findOrFail($request->id);

            // Check if the current dispatch_status is already 'Dispatched'
            $alreadyDispatched = $qrData->dispatch_status === 'Dispatched';

            // Update the model with the validated data if not already dispatched
            if (!$alreadyDispatched) {
                $qrData->update([
                    'dispatch_status' => 'Dispatched',
                    'supervisor' => $request->supervisor_id, // Set the supervisor to the authenticated user's ID
                ]);
            }

            // Return the updated data as a JSON response
            return response()->json([
                'success' => true,
                'flag' => $alreadyDispatched ? 'Already Dispatched' : 'Success',
                'data' => $qrData
            ]);
        } catch (\Exception $e) {
            // Log the error and return a JSON response with an error message
            return response()->json([
                'success' => false,
                'flag' => $e->getMessage(),
                'auth' => Auth::user(),
                'data' => null
            ]);
        }
    }


    public function UpdatetrollyStatus(Request $request)
    {
        // return $request;
        $data = $request->validate([
            'trolly_name' => 'required|string',
            'supervisor' => 'required|string',
            'supervisor_id' => 'required|string',
            'department' => 'required|string',
            'place' => 'required|string',
            'quantity' => 'required|integer'
        ]);

        try {
            $existingRecord = ProductivityReport::where('trolly_name', $data['trolly_name'])
                ->where('supervisor', $data['supervisor'])
                ->whereNull('exit_time')
                ->first();

            if ($existingRecord) {
                return response()->json([
                    'error' => 'You have already scanned this trolly.',
                    'status' => 200
                ]);
            }

            $newRecord = [
                'trolly_name' => $data['trolly_name'],
                'supervisor' => $data['supervisor_id'],
                'department' => $data['department'],
                'name' => $data['supervisor'],
                'entry_time' => Carbon::now(),
                'place' => $data['place'],
                'quantity' => $data['quantity']
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

            return response()->json([
                'message' => 'Data stored successfully',
                'status' => 200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while storing the data: ' . $e->getMessage(),
                'status' => 200
            ]);
        }
    }
}
