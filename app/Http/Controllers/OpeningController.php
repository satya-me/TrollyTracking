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
        ]);

        Opening::create($request->all());

        return redirect()->back()->with('success', 'Opening added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'department' => 'required',
            'opening' => 'required|numeric',
        ]);

        $opening = Opening::findOrFail($id);
        $opening->update($request->all());

        return redirect()->back()->with('success', 'Opening updated successfully.');
    }

    public function destroy($id)
    {
        $opening = Opening::findOrFail($id);
        $opening->delete();

        return redirect()->back()->with('success', 'Opening deleted successfully.');
    }
}
