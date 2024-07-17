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
        // Static department names
        $staticDepartments = [
            'RCN RECEVING', 'RCN GRADING', 'RCN BOILING', 'SCOOPING', 'BORMA/ DRYING',
            'PEELING', 'SMALL TAIHO', 'MAYUR', 'HAMSA', 'WHOLES GRADING', 'LW GRADING',
            'SHORTING', 'DP & DS GRADING', 'PACKING'
        ];

        // Fetch all scan data
        $scans = ProductivityReport::select('place', 'quantity', 'department', 'created_at')
            ->orderBy('created_at', 'asc')
            ->get();

        // Fetch opening quantities from the Opening table
        $openings = Opening::select('department', 'opening')->get()->pluck('opening', 'department')->toArray();

        // Initialize arrays to store the get and send quantities
        $departmentData = [];

        foreach ($scans as $scan) {

            //return $yesterday=ProductivityReport::where('place',$scan->place)->where('quantity',$scan->quantity)->get();

            $fromDepartment = $scan->department;
            $toPlace = $scan->place;
            $quantity = $scan->quantity;

            // Initialize department data if not already set
            if (!isset($departmentData[$toPlace])) {
                $departmentData[$toPlace] = [
                    'place' => $toPlace,
                    'opening' => isset($openings[$toPlace]) ? $openings[$toPlace] : 0, // Get opening from the fetched data or default to 0
                    'get_quantity' => 0,
                    'send_quantity' => 0,
                    'backlog' => 0 // Initialize backlog
                ];
            }

            if (!isset($departmentData[$fromDepartment])) {
                $departmentData[$fromDepartment] = [
                    'place' => $fromDepartment,
                    'opening' => isset($openings[$fromDepartment]) ? $openings[$fromDepartment] : 0, // Get opening from the fetched data or default to 0
                    'get_quantity' => 0,
                    'send_quantity' => 0,
                    'backlog' => 0 // Initialize backlog
                ];
            }

            // Increment get quantity for the place being sent to
            $departmentData[$toPlace]['get_quantity'] += $quantity;

            // Increment send quantity for the department sending the trolley
            $departmentData[$fromDepartment]['send_quantity'] += $quantity;
        }

        // Calculate opening and backlog values
        foreach ($departmentData as &$data) {
            $department = $data['place'];
            $previousBacklog = isset($openings[$department]) ? $openings[$department] : 0;
            $data['opening'] = $previousBacklog; // Add previous day's backlog to today's opening
            $data['backlog'] = $data['opening'] + $data['get_quantity'] - $data['send_quantity']; // Calculate backlog
        }

        // Ensure all static departments are included in $departmentData with '--' if no data exists
        foreach ($staticDepartments as $departmentName) {
            if (!isset($departmentData[$departmentName])) {
                $departmentData[$departmentName] = [
                    'place' => $departmentName,
                    'opening' => 0,
                    'get_quantity' => 0,
                    'send_quantity' => 0,
                    'backlog' => 0
                ];
            }
        }

        // Sort $departmentData by department name
        ksort($departmentData);

        return view('Admin.product_summery', [
            'data' => $departmentData,
            'scans' => $scans, // Pass $scans variable to the view
        ]);
    }

}
