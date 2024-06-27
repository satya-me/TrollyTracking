<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\QRData;
use Illuminate\View\View;
use App\Models\QRTempData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class QRController extends Controller
{

    public function QRGen(Request $request)
    {
        // dd(auth()->user()->type);
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
            return view('Admin.qr', compact('qrCode', 'qr', 'qr_url'));
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
        $_PAGINATE = 50;

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
        } elseif (isset($_GET['status']) && $_GET['status'] != null && $_GET['status'] != 'Open this select menu') {
            $qr_latest = QRData::where('dispatch_status', $_GET['status'])->orderBy('created_at', 'desc')->paginate($_PAGINATE);
        } elseif (isset($_GET['search_item']) && $_GET['search_item'] != null) {
            $searchItem = $_GET['search_item'];

            $qr_latest = QRData::where('grade_name', 'LIKE', "%{$searchItem}%")
                ->orWhere('batch_no', 'LIKE', "%{$searchItem}%")
                ->orWhere('lot_no', 'LIKE', "%{$searchItem}%")
                ->orderBy('created_at', 'desc')
                ->paginate($_PAGINATE);
        } else {
            $qr_latest = QRData::orderBy('created_at', 'desc')->paginate($_PAGINATE);
            // return $qr_latest;
        }

        if (auth()->user()->type == "admin") {
            return view('Admin.qr-report', compact('qr_latest'));
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

    public function downloadQRCodeView()
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

        $ch_wn = curl_init($qrCodeUrl);
        $download_qr = public_path('qrcode_download/qr_' . $qr_latest->id . '.png');

        // Ensure the directory exists
        if (!is_dir(public_path('qrcodes'))) {
            mkdir(public_path('qrcodes'), 0755, true);
        }

        // Open file for writing
        $fp_dwn = fopen($download_qr, 'wb');

        try {
            // Set cURL options
            curl_setopt($ch_wn, CURLOPT_FILE, $fp_dwn);
            curl_setopt($ch_wn, CURLOPT_HEADER, 0);
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
}
