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
            return view('Admin.qr', compact('qrCode', 'qr', 'qr_url', 'gradenames', 'origins'));
        }
        if (auth()->user()->type == "user") {
            return view('User.qr', compact('qrCode', 'qr', 'qr_url'));
        }
        if (auth()->user()->type == "supervisor") {
            return view('Supervisor.qr', compact('qrCode', 'qr', 'qr_url'));
        }
    }

    public function QRCodeReport(Request $request)
    {
        $_PAGINATE = 10;
        $gradenames = Gradename::all();
        $origins = Origin::all();

        //$totalCount = 0; // Initialize total count
        $totalCount = QRData::count(); // Get the total count of all records
        $qr_latest = null; // Initialize qr_latest
        // Count of In_Stock items
        $inStockCount = QRData::where('dispatch_status', 'In_Stock')->count();

        // Count of Dispatched items
        $dispatchedCount = QRData::where('dispatch_status', 'Dispatched')->count();
        $inhand = $totalCount  - $dispatchedCount;



        if ($request->has('date_range') && $request->input('date_range') != null) {
            $dateRange = $request->input('date_range');

            list($startDate, $endDate) = explode(' - ', $dateRange);

            $fromDate = Carbon::createFromFormat('m/d/Y', $startDate)->startOfDay();
            $toDate = Carbon::createFromFormat('m/d/Y', $endDate)->endOfDay();

            $formattedFromDate = $fromDate->format('Y-m-d H:i:s');
            $formattedToDate = $toDate->format('Y-m-d H:i:s');

            $qr_latest = QRData::whereBetween('created_at', [$formattedFromDate, $formattedToDate])
                ->orderBy('id', 'desc')
                ->paginate($_PAGINATE);
        } elseif ($request->has('status') && $request->input('status') != null) {
            $status = $request->input('status');
            $qr_latest = QRData::where('dispatch_status', $status)
                ->orderBy('created_at', 'desc')
                ->paginate($_PAGINATE);
            // $totalCount = QRData::where('dispatch_status', $status)->count(); // Update the total count based on the status
        } elseif ($request->has('search_item') && $request->input('search_item') != null) {
            $searchItem = $request->input('search_item');

            $qr_latest = QRData::where('grade_name', 'LIKE', "%{$searchItem}%")
                ->orWhere('batch_no', 'LIKE', "%{$searchItem}%")
                ->orWhere('lot_no', 'LIKE', "%{$searchItem}%")
                ->orderBy('created_at', 'desc')
                ->paginate($_PAGINATE);
            // $totalCount = QRData::where('grade_name', 'LIKE', "%{$searchItem}%")
            //     ->orWhere('batch_no', 'LIKE', "%{$searchItem}%")
            //     ->orWhere('lot_no', 'LIKE', "%{$searchItem}%")
            //     ->count(); // Update the total count based on the search item
        } else {
            $qr_latest = QRData::orderBy('created_at', 'desc')->paginate($_PAGINATE);
        }

        if (auth()->user()->type == "admin") {
            return view('Admin.qr-report', compact('qr_latest', 'gradenames', 'origins', 'totalCount', 'inStockCount', 'dispatchedCount', 'inhand'));
        }
        if (auth()->user()->type == "user") {
            return view('Supervisor.qr-report', compact('qr_latest', 'totalCount'));
        }
    }

    public function search(Request $request)
    {
        // Fetch all gradenames and origins
        $gradenames = Gradename::all();
        $origins = Origin::all();

        // Pagination count
        $_PAGINATE = 10;

        // Initialize query builder
        $query = QRData::query();

        // Extract inputs
        $grade = $request->input('grade_name');
        $dispatch_status = $request->input('dispatch_status');
        $batch_no = $request->input('batch_no');
        $lot_no = $request->input('lot_no');

        // Date range filter
        if ($request->has('date_range') && $request->input('date_range') != null) {
            $dateRange = $request->input('date_range');
            list($startDate, $endDate) = explode(' - ', $dateRange);

            $fromDate = Carbon::createFromFormat('m/d/Y', $startDate)->startOfDay();
            $toDate = Carbon::createFromFormat('m/d/Y', $endDate)->endOfDay();

            $formattedFromDate = $fromDate->format('Y-m-d H:i:s');
            $formattedToDate = $toDate->format('Y-m-d H:i:s');

            $query->whereBetween('created_at', [$formattedFromDate, $formattedToDate]);
        }

        // Filter by grade_name (AND condition)
        if ($grade != '') {
            $query->where('grade_name', 'LIKE', "%{$grade}%");
        }

        // Filter by batch, lot, dispatch_status (OR condition)
        if ($batch_no != '') {
            $query->Where('batch_no', 'LIKE', "%{$batch_no}%");
        }

        if ($lot_no != '') {
            $query->Where('lot_no', 'LIKE', "%{$lot_no}%");
        }

        if ($dispatch_status != '') {
            $query->Where('dispatch_status', 'LIKE', "%{$dispatch_status}%");
        }

        // Order by created_at descending
        $query->orderBy('created_at', 'desc');
        // Paginate the results
        $qr_latest = $query->paginate($_PAGINATE);

        // Total count of QRData records
        $totalCount = QRData::count();

        if ($grade != '') {
            $totalCount = QRData::where('grade_name',  'LIKE', "%{$grade}%")->count();
            $inStockCount = $query->where('grade_name',  'LIKE', "%{$grade}%")->where('dispatch_status', 'In_Stock')->count();
            $dispatchedCount = $totalCount - $inStockCount;
            $inhand = $totalCount - $dispatchedCount;
        } else {
            $inStockCount = QRData::where('dispatch_status', 'In_Stock')->count();
            $dispatchedCount = QRData::where('dispatch_status', 'Dispatched')->count();
            $inhand = $totalCount - $dispatchedCount;
        }


        // Return view with data
        return view('Admin.qr-report', compact('qr_latest', 'gradenames', 'origins', 'totalCount', 'inStockCount', 'dispatchedCount', 'inhand'));
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
        // $qr_latest = QRData::latest()->first()->makeHidden(['supervisor', 'created_at', 'updated_at']);
        $qr_latest = QRData::latest()->first();

        if ($qr_latest) {
            $qr_latest->makeHidden(['supervisor', 'created_at', 'updated_at']);
        } else {
            // Handle the case when there are no records
            // For example, you can set $qr_latest to a default value or log an error
            $qr_latest = ''; // Or any appropriate default value
        }

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
