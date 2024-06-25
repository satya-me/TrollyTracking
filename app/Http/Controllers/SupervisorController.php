<?php

namespace App\Http\Controllers;

use App\Models\QRData;
use Log;
use App\Models\User;
use Illuminate\Bus\Events\BatchDispatched;
use Illuminate\Http\Request;

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
}
