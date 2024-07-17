<?php

namespace App\Http\Controllers;

use App\Models\Opening;
use App\Models\Backlog;
use App\Models\ProductivityReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BacklogController extends Controller
{
    public function updateBacklog()
    {
        try {
            // Fetch all unique departments from both `department` and `place` columns
            $departments = ProductivityReport::select('department')
                ->union(ProductivityReport::select('place'))
                ->distinct()
                ->pluck('department')
                ->toArray();

            Log::info("Total unique departments to process: " . count($departments));

            foreach ($departments as $department) {
                try {
                    // Fetch the opening for the department
                    $opening = Opening::where('department', $department)->first();
                    Log::info("Processing Department: $department");

                    // Calculate 'get' and 'send' quantities
                    $getQuantity = ProductivityReport::where('place', $department)->sum('quantity');
                    $sendQuantity = ProductivityReport::where('department', $department)->sum('quantity');

                    Log::info("Department: $department, getQuantity: $getQuantity, sendQuantity: $sendQuantity");

                    // Handle opening value
                    $openingValue = $opening ? $opening->opening : 0;

                    // Calculate backlog
                    $backlog = $openingValue + $getQuantity - $sendQuantity;

                    Log::info("Department: $department, Opening: $openingValue, Backlog: $backlog");

                    // Update or create the backlog record
                    $updatedBacklog = Backlog::updateOrCreate(
                        ['department' => $department],
                        ['backlog' => $backlog]
                    );

                    // Log the updated backlog record for debugging
                    Log::info("Updated Backlog Record for Department: $department", $updatedBacklog->toArray());
                } catch (\Throwable $e) {
                    // Log the error message and stack trace
                    Log::error("Error processing item for department $department: " . $e->getMessage());
                    Log::error("Stack trace: " . $e->getTraceAsString());
                }
            }

            // Commit transaction if using transactions
            // DB::commit();

            return redirect()->back()->with('success', 'Backlogs updated successfully');
        } catch (\Exception $e) {
            // Rollback transaction if using transactions
            // DB::rollBack();

            return redirect()->back()->with('error', 'Failed to update backlogs: ' . $e->getMessage());
        }
    }


    // public function updateBacklog()
    // {
    //     try {
    //         $data = ProductivityReport::all();

    //         // Initialize an array to hold calculated backlogs
    //         $backlogs = [];

    //         foreach ($data as $item) {
    //             $department = $item->place;
    //             $opening = Opening::where('department', $department)->firstOrFail();

    //             // Calculate 'get' and 'send' quantities for this department
    //             $getQuantity = $data->where('place', $department)->sum('quantity');
    //             $sendQuantity = $data->where('department', $department)->sum('quantity');

    //             // Calculate backlog
    //             $backlog = $opening->opening + $getQuantity - $sendQuantity;

    //             // Store calculated backlog in the array
    //             $backlogs[$department] = $backlog;
    //         }

    //         // Update or create backlog records for all departments
    //         foreach ($backlogs as $department => $backlog) {
    //             Backlog::updateOrCreate(
    //                 ['department' => $department],
    //                 ['backlog' => $backlog]
    //             );
    //         }

    //         return redirect()->back()->with('success', 'Backlogs updated successfully');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Failed to update backlogs: ' . $e->getMessage());
    //     }
    // }



    public function Cron()
    {
        // $backLog = Backlog::get();
        // $opening = Opening::get();
        // return [
        //     "backLog" => $backLog,
        //     "opening" => $opening,
        // ];

        $backlogs = Backlog::all();

        foreach ($backlogs as $backlog) {
            $opening = Opening::where('department', $backlog->department)->first();

            if ($opening) {
                $opening->opening = $backlog->backlog;
                $opening->save();
            }
        }

        return response()->json(['message' => 'Openings updated successfully.']);
    }
}
