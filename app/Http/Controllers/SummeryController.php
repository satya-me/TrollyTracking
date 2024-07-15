<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductivityReport; // Replace with the actual model name for scans
use App\Models\Opening;
use Carbon\Carbon;

class SummeryController extends Controller
{
    public function summery()
    {
        // Fetch all scan data
        $scans = ProductivityReport::select('place', 'quantity', 'department', 'created_at')
            ->orderBy('created_at', 'asc')
            ->get();

        // Fetch opening quantities from the Opening table
        $openings = Opening::select('department', 'opening')->get()->pluck('opening', 'department')->toArray();

        // Initialize arrays to store the get and send quantities
        $departmentData = [];

        foreach ($scans as $scan) {
            $fromDepartment = $scan->department;
            $toPlace = $scan->place;
            $quantity = $scan->quantity;

            // Initialize department data if not already set
            if (!isset($departmentData[$toPlace])) {
                $departmentData[$toPlace] = [
                    'place' => $toPlace,
                    'opening' => $openings[$toPlace] ?? 0, // Get opening from the fetched data
                    'get_quantity' => 0,
                    'send_quantity' => 0
                ];
            }

            if (!isset($departmentData[$fromDepartment])) {
                $departmentData[$fromDepartment] = [
                    'place' => $fromDepartment,
                    'opening' => $openings[$fromDepartment] ?? 0, // Get opening from the fetched data
                    'get_quantity' => 0,
                    'send_quantity' => 0
                ];
            }

            // Increment get quantity for the place being sent to
            $departmentData[$toPlace]['get_quantity'] += $quantity;

            // Increment send quantity for the department sending the trolley
            $departmentData[$fromDepartment]['send_quantity'] += $quantity;
        }

        return view('Admin.product_summery', ['data' => $departmentData]);
    }
}
