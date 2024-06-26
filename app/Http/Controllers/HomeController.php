<?php

namespace App\Http\Controllers;

use App\Models\QRData;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\ProductivityReport;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): View
    {
        return view('User.home');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function Dashboard(): View
    // {
    //     return view('Admin.dashboard');
    // }

    public function adminHome(): View
    {
        return view('Admin.dashboard');
    }

    public function supervisorHome(): View
    {
        $startDate = now()->startOfDay()->toDateTimeString();
        $endDate = now()->endOfDay()->toDateTimeString();
        $_USER = Auth::user();
        $yesterday_trolly_scan = ProductivityReport::whereBetween('created_at', [now()->subDay()->startOfDay()->toDateTimeString(), now()->subDay()->endOfDay()->toDateTimeString()])
        ->count();
        $today_trolly_scan = ProductivityReport::whereBetween('created_at', [$startDate, $endDate])
        ->count();
        $yesterday_dispatch_scan = QRData::whereBetween('created_at', [now()->subDay()->startOfDay()->toDateTimeString(), now()->subDay()->endOfDay()->toDateTimeString()])
        ->count();
        $today_dispatch_scan = QRData::whereBetween('created_at', [$startDate, $endDate])
        ->count();
        $today_sacn=$today_trolly_scan + $today_dispatch_scan;
        $yesterday_scan=$yesterday_trolly_scan + $yesterday_dispatch_scan;

        return view('Supervisor.home',compact('today_dispatch_scan','yesterday_dispatch_scan'));
    }
}
