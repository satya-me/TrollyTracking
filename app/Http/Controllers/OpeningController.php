<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opening;

class OpeningController extends Controller
{
    public function index()
    {
        $openings = Opening::all();
        return view('admin.opening', compact('openings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'department' => 'required',
            'opening' => 'required|numeric',
            'is_new_opening' => 'required|string'
        ]);

        Opening::create($request->all());

        return redirect()->back()->with('success', 'Opening added successfully.');
    }

    public function update(Request $request)
    {
        // return $request->open_id;
        $request->validate([
            'department' => 'required',
            'opening' => 'required|numeric',
            'is_new_opening' => 'required|string'
        ]);

        // Use findOrFail to handle cases where the record might not exist
        $opening = Opening::findOrFail($request->open_id);
        $opening->department = $request->department;
        $opening->opening = $request->opening;
        $opening->is_new_opening = $request->is_new_opening;
        $opening->save();

        return redirect()->back()->with('success', 'Opening updated successfully.');
    }

    public function destroy($id)
    {
        $opening = Opening::findOrFail($id);
        $opening->delete();

        return redirect()->back()->with('success', 'Opening deleted successfully.');
    }
}
