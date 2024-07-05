<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Origin;
use App\Models\QRData;
use App\Models\Gradename;
use Illuminate\View\View;
use App\Models\QRTempData;
use Illuminate\Http\Request;
use App\Exports\QRDataExport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class QRController extends Controller
{

    public function QRGen(Request $request)
    {
        // dd(auth()->user()->type);
        $gradenames = Gradename::all();
        $origins = Origin::all();
        $folderPath = public_path('qrcodes');
        $files = File::files($folderPath);

        foreach ($files as $file) {
            File::delete($file);
        }
        $qr = QRTempData::first();
        $qr_latest = QRData::latest()->first();
        $LST_ID = $qr_latest->id ?? 0;
        $qrCode = $this->QRCodeImage($LST_ID);
        $qr_url = asset('qrcodes/qr_' . $LST_ID . '.png');
        // return auth()->user();
        if (auth()->user()->type == "admin") {
            return view('Admin.qr', compact('qrCode', 'qr', 'qr_url','gradenames', 'origins'));
        }
        if (auth()->user()->type == "user") {
            return view('User.qr', compact('qrCode', 'qr', 'qr_url'));
        }
        if (auth()->user()->type == "supervisor") {
            return view('Supervisor.qr', compact('qrCode', 'qr', 'qr_url'));
        }
    }



    // public function QRCodeReport(Request $request)
    // {
    //     $_PAGINATE = 50;

    //     // Initialize query builder
    //     $query = QRData::query();

    //     // Date Range filter
    //     if (isset($_GET['date_range']) && $_GET['date_range'] != null) {
    //         $dateRange = $_GET['date_range'];
    //         list($startDate, $endDate) = explode(' - ', $dateRange);

    //         $fromDate = Carbon::createFromFormat('m/d/Y', $startDate)->startOfDay();
    //         $toDate = Carbon::createFromFormat('m/d/Y', $endDate)->endOfDay();

    //         $formattedFromDate = $fromDate->format('Y-m-d H:i:s');
    //         $formattedToDate = $toDate->format('Y-m-d H:i:s');

    //         $query->whereBetween('created_at', [$formattedFromDate, $formattedToDate]);
    //     }

    //     // Status filter
    //     if (isset($_GET['status']) && $_GET['status'] != null && $_GET['status'] != 'Open this select menu') {
    //         $query->where('dispatch_status', $_GET['status']);
    //     }

    //     // Grade Name filter
    //     if (isset($_GET['grade_name']) && $_GET['grade_name'] != null) {
    //         $gradeName = $_GET['grade_name'];
    //         $query->where('grade_name', 'LIKE', "%{$gradeName}%");
    //     }

    //     // Execute the query and paginate results
    //     $qr_latest = $query->orderBy('created_at', 'desc')->paginate($_PAGINATE);

    //     // Return view based on user type
    //     if (auth()->user()->type == "admin") {
    //         return view('Admin.qr-report', compact('qr_latest'));
    //     } elseif (auth()->user()->type == "user") {
    //         return view('Supervisor.qr-report', compact('qr_latest'));
    //     }
    // }

    public function QRCodeReport(Request $request)
    {
        $_PAGINATE = 50;
        $gradenames = Gradename::all();
        $origins = Origin::all();

        if (isset($_GET['date_range']) && $_GET['date_range'] != null) {
            $dateRange = $_GET['date_range'];

            list($startDate, $endDate) = explode(' - ', $dateRange);

            $fromDate = Carbon::createFromFormat('m/d/Y', $startDate)->startOfDay();
            $toDate = Carbon::createFromFormat('m/d/Y', $endDate)->endOfDay();

            $formattedFromDate = $fromDate->format('Y-m-d H:i:s');
            $formattedToDate = $toDate->format('Y-m-d H:i:s');

            $qr_latest = QRData::whereBetween('created_at', [$formattedFromDate, $formattedToDate])
                ->orderBy('id', 'desc')
                ->paginate($_PAGINATE);
        }
        elseif (isset($_GET['status']) && $_GET['status'] != null && $_GET['status'] != 'Open this select menu') {
            $qr_latest = QRData::where('dispatch_status', $_GET['status'])->orderBy('created_at', 'desc')->paginate($_PAGINATE);
        }
        elseif (isset($_GET['search_item']) && $_GET['search_item'] != null) {
            $searchItem = $_GET['search_item'];

            $qr_latest = QRData::where('grade_name', 'LIKE', "%{$searchItem}%")
                        ->orWhere('batch_no', 'LIKE', "%{$searchItem}%")
                        ->orWhere('lot_no', 'LIKE', "%{$searchItem}%")
                        ->orderBy('created_at', 'desc')
                        ->paginate($_PAGINATE);
        }
        else {
            $qr_latest = QRData::orderBy('created_at', 'desc')->paginate($_PAGINATE);
            // return $qr_latest;
        }

        if (auth()->user()->type == "admin") {
            return view('Admin.qr-report', compact('qr_latest','gradenames', 'origins'));
        }
        if (auth()->user()->type == "user") {
            return view('Supervisor.qr-report', compact('qr_latest'));
        }
    }

    public function QRTempData(Request $request)
    {
        $data = $request->only(['grade_name', 'origin', 'batch_no', 'net_weight', 'gross_weight', 'lot_no']);

        // Check if the record exists in the database based on batch_no
        $existingRecord = QRTempData::where('batch_no', $data['batch_no'])->first();

        if ($existingRecord) {
            // Update the existing record
            $existingRecord->update($data);
            QRData::create($data);
            $message = 'Data updated successfully.';
        } else {
            // Insert a new record
            QRTempData::create($data);
            QRData::create($data);
            $message = 'Data inserted successfully.';
        }

        if (Auth::user()->role == "Admin") {
            # code...
            return redirect()->route('admin.qr')->with('message', $message);
        }
        if (Auth::user()->role == "User") {
            return redirect()->route('user.qr')->with('message', $message);
        }


        // return redirect()->back()->with('message', $message);
        // return response()->json(['message' => $message]);
    }

    public function downloadQRCode(Request $request)
    {
        // Fetch QR code data from database
        $qrData = QRTempData::first();
        $qr_latest = QRData::latest()->first()->makeHidden(['supervisor', 'created_at', 'updated_at']);
        if (!$qrData) {
            return response()->json(['error' => 'No QR data found'], 404);
        }

        // Generate QR code image URL
        $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=" . urlencode($qr_latest);

        // Initialize cURL session
        $ch = curl_init($qrCodeUrl);
        $qrCodePath = public_path('qrcodes/qr_' . $qr_latest->id . '.png');
        // Ensure the directory exists
        if (!is_dir(public_path('qrcodes'))) {
            mkdir(public_path('qrcodes'), 0755, true);
        }

        // Open file for writing
        $fp = fopen($qrCodePath, 'wb');
        if (!$ch || !$fp) {
            if ($fp) fclose($fp);
            if ($ch) curl_close($ch);
            return response()->json(['error' => 'Error initializing cURL or file handle'], 500);
        }

        try {
            // Set cURL options
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_HEADER, 0);

            if (!curl_exec($ch)) {
                throw new \Exception('cURL error: ' . curl_error($ch));
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } finally {
            // Close cURL session and file handle
            curl_close($ch);
            fclose($fp);
        }

        // Check if QR code image was generated successfully
        if (!file_exists($qrCodePath)) {
            return response()->json(['error' => 'QR code image not generated'], 500);
        }

        // Download the QR code file
        return response()->download($qrCodePath)->deleteFileAfterSend(true);
    }

    public function downloadQRCodeView(Request $request)
    {
        // Retrieve QR data
        $qr_latest = QRData::where('id', $request->id)->first();

        // Check if QR data is found
        if (!$qr_latest) {
            return response()->json(['error' => 'No QR data found'], 404);
        }

        // Hide specified attributes
        $qr_latest->makeHidden(['supervisor', 'created_at', 'updated_at']);

        // Generate QR code image URL
        $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=" . urlencode($qr_latest);

        // Ensure the directory exists
        $qrDirectory = public_path('qrcodes');
        if (!is_dir($qrDirectory)) {
            mkdir($qrDirectory, 0755, true);
        }

        // Path to save the downloaded QR code image
        $download_qr = $qrDirectory . '/qr_' . $qr_latest->id . '.png';

        // Initialize cURL session
        $ch_wn = curl_init($qrCodeUrl);

        // Open file for writing
        $fp_dwn = fopen($download_qr, 'wb');

        if ($ch_wn === false || $fp_dwn === false) {
            return response()->json(['error' => 'Failed to initialize cURL or open file'], 500);
        }

        try {
            // Set cURL options
            curl_setopt($ch_wn, CURLOPT_FILE, $fp_dwn);
            curl_setopt($ch_wn, CURLOPT_HEADER, 0);

            // Execute cURL session
            curl_exec($ch_wn);

            // Check for cURL errors
            if (curl_errno($ch_wn)) {
                return response()->json(['error' => 'cURL error: ' . curl_error($ch_wn)], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } finally {
            // Close cURL session and file handle
            curl_close($ch_wn);
            fclose($fp_dwn);
        }

        // Check if QR code image was generated successfully
        if (!file_exists($download_qr)) {
            return response()->json(['error' => 'QR code image not generated'], 500);
        }

        // Download the QR code file
        return response()->download($download_qr)->deleteFileAfterSend(true);
    }

    public function QRCodeImage($id)
    {
        // Fetch QR code data from database
        $qrData = QRTempData::first();
        $qr_latest = QRData::latest()->first()->makeHidden(['supervisor', 'created_at', 'updated_at']);
        if (!$qrData) {
            return response()->json(['error' => 'No QR data found'], 404);
        }

        // Generate QR code image URL
        $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=" . urlencode($qr_latest);

        // Initialize cURL session
        $ch = curl_init($qrCodeUrl);
        $qrCodePath = public_path('qrcodes/qr_' . $id . '.png');

        // Ensure the directory exists
        if (!is_dir(public_path('qrcodes'))) {
            mkdir(public_path('qrcodes'), 0755, true);
        }

        // Open file for writing
        $fp = fopen($qrCodePath, 'wb');
        if (!$ch || !$fp) {
            if ($fp) fclose($fp);
            if ($ch) curl_close($ch);
            return response()->json(['error' => 'Error initializing cURL or file handle'], 500);
        }

        try {
            // Set cURL options
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            if (!curl_exec($ch)) {
                throw new \Exception('cURL error: ' . curl_error($ch));
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } finally {
            // Close cURL session and file handle
            curl_close($ch);
            fclose($fp);
        }

        // Check if QR code image was generated successfully
        if (!file_exists($qrCodePath)) {
            return response()->json(['error' => 'QR code image not generated'], 500);
        }
        return $qrCodePath;
        // Download the QR code file
        // return response()->download($qrCodePath)->deleteFileAfterSend(true);
    }

    public function downloadExcel(Request $request)
    {
        $gradeName = $request->input('grade_name');
        $dispatchStatus = 'In_Stock';

        return Excel::download(new QRDataExport($gradeName, $dispatchStatus), 'qr_data.xlsx');
    }

}
