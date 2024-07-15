<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ProductivityReportController extends Controller
{
    public function ScanTrollyQR()
    {
        return view('Supervisor.scan-trolly');
    }

    public function summery()
    {
        return view('Admin.product_summery');
    }
}
