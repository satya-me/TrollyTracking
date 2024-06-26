<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ProductivityReport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductivityReportExport;

class AdminController extends Controller
{
    public function AddSupervisor(Request $request)
    {
        // Check if the user already exists
        $existingUser = User::where('email', $request->username)->first();

        if ($existingUser) {
            return redirect()->back()->with('error', 'User with this email already exists.');
        }


        $user = new User;
        $user->name = $request->name;
        $user->email  = $request->username;
        $user->phone = $request->phone;
        $user->department = $request->department;
        $user->password = $request->password;
        $user->temp_password = $request->password;
        $user->type = 2;
        $user->role = 'Supervisor';
        $user->save();

        return redirect()->route('admin.supervisor')->with('success', 'User created successfully.');
    }

    public function SupervisorView(Request $request)
    {
        $allSupervisor = User::where(['type' => 2])->orderBy('created_at', 'desc')->get();
        return view('Admin.supervisor', compact('allSupervisor'));
    }

    public function Productivity(Request $request)
    {
        $data = ProductivityReport::get();
        return view('Admin.productivity', compact('data'));
    }

    public function editSupervisor($id)
    {
        $supervisor = User::find($id);
        return view('admin.edit_supervisor', compact('supervisor'));
    }

    public function updateSupervisor(Request $request)
    {
        // return $request;

        $supervisor = User::find($request->id);
        $supervisor->name = $request->name;
        $supervisor->email = $request->username;
        $supervisor->phone = $request->phone;
        $supervisor->department = $request->department;
        // if (!empty($request->password)) {
        //     $supervisor->password = $request->password;
        //     $supervisor->temp_password = $request->password;
        // }
        $supervisor->save();

        return redirect()->route('admin.supervisor')->with('success', 'Supervisor updated successfully.');
    }

    public function deleteSupervisor($id)
    {
        $supervisor = User::find($id);
        $supervisor->delete();

        return redirect()->route('admin.supervisor')->with('success', 'Supervisor removed successfully.');
    }


    public function productivityReport(Request $request)
    {
        $_PAGINATE = 50;

        if ($request->has('date_range') && $request->date_range != null) {
            $dateRange = $request->date_range;

            list($startDate, $endDate) = explode(' - ', $dateRange);

            $fromDate = Carbon::createFromFormat('m/d/Y', $startDate)->startOfDay();
            $toDate = Carbon::createFromFormat('m/d/Y', $endDate)->endOfDay();

            $formattedFromDate = $fromDate->format('Y-m-d H:i:s');
            $formattedToDate = $toDate->format('Y-m-d H:i:s');

            $qr_latest = ProductivityReport::whereBetween('created_at', [$formattedFromDate, $formattedToDate])
                ->orderBy('id', 'desc')
                ->paginate($_PAGINATE);
        } else {
            $qr_latest = ProductivityReport::orderBy('created_at', 'desc')->paginate($_PAGINATE);
        }

        if (auth()->user()->type == "admin") {
            return view('Admin.qr-report', compact('qr_latest'));
        }
        if (auth()->user()->type == "user") {
            return view('Supervisor.qr-report', compact('qr_latest'));
        }
    }

    public function productivityReportDownload(Request $request)
    {
        // return $request;
        $_DEPARTMENT = $request->department;
        if ($request->date_range != null) {
            $dateRange = $_GET['date_range'];

            list($startDate, $endDate) = explode(' - ', $dateRange);

            $_START = Carbon::createFromFormat('m/d/Y', $startDate)->toDateString();
            $_END = Carbon::createFromFormat('m/d/Y', $startDate)->toDateString();

            $fromDate = Carbon::createFromFormat('m/d/Y', $startDate)->startOfDay();
            $toDate = Carbon::createFromFormat('m/d/Y', $endDate)->endOfDay();

            $fromDate = $fromDate->toDateTimeString();
            $toDate = $toDate->toDateTimeString();
        } else {
            return redirect()->back()->with('error', 'Please select a date range');
        }

        return (new ProductivityReportExport($fromDate, $toDate, $_DEPARTMENT))
            ->download('Productivity_Report ' . $_START . ' - ' . $_END . '.csv');


        // Generate Excel file
        // return Excel::download(new ProductivityReportExport($qr_latest), 'productivity_report.xlsx');
    }
}














// if ($request->has('date_range') && $request->date_range != null) {
//     $dateRange = $request->date_range;
//     list($startDate, $endDate) = explode(' - ', $dateRange);
//     $fromDate = Carbon::createFromFormat('m/d/Y', $startDate)->startOfDay();
//     $toDate = Carbon::createFromFormat('m/d/Y', $endDate)->endOfDay();
//     $formattedFromDate = $fromDate->format('Y-m-d H:i:s');
//     $formattedToDate = $toDate->format('Y-m-d H:i:s');
// } else {
//     $formattedFromDate = null;
//     $formattedToDate = null;
// }

// // Check if department is provided and not equal to 'ALL'
// if ($request->has('department') && $request->department != 'ALL') {
//     $department = $request->department;
// } else {
//     $department = null;
// }

// // Initialize the query
// $query = ProductivityReport::query();

// // Apply date range filter if provided
// if ($formattedFromDate && $formattedToDate) {
//     $query->whereBetween('created_at', [$formattedFromDate, $formattedToDate]);
// }

// // Apply department filter if provided
// if ($department) {
//     $query->where('department', $department);
// }

// // Get the filtered data
// $qr_latest = $query->orderBy('created_at', 'desc')->get();
