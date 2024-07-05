<?php

namespace App\Http\Controllers;

use App\Models\Origin;
use App\Models\Gradename;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function view()
    {
        $data=Gradename::all();
        $dataorigin = Origin::all();
        return view('settings.view', compact('data','dataorigin'));
    }

    public function create_grade(Request $request)
    {
        $request->validate([
            'grade_name' => 'required|string|max:255',
        ]);

        Gradename::create([
            'grade_name' => $request->grade_name,
        ]);

        return redirect()->back()->with('success', 'Grade added successfully.');
    }

    public function editGrade($id)
    {
        $grade = Gradename::find($id);
        return response()->json($grade);
    }

    public function updateGrade(Request $request)
    {
        // return $request;
        $request->validate([
            'grade_name' => 'required|string|max:255',
        ]);

        $grade = Gradename::find($request->grade_id);
        $grade->grade_name = $request->grade_name;
        $grade->save();

        return redirect()->back()->with('success', 'Grade updated successfully.');
    }

    public function deleteGrade($id)
    {
        $grade = Gradename::find($id);
        $grade->delete();

        return redirect()->back()->with('success', 'Grade deleted successfully.');
    }

    public function create_origin(Request $request)
    {
        $request->validate([
            'origin' => 'required|string|max:255',
        ]);

        Origin::create([
            'origin' => $request->origin,
        ]);

        return redirect()->back()->with('success', 'Origin added successfully!');
    }

    public function editorigin($id)
    {
        $origin = Origin::find($id);

        return response()->json($origin);
    }

    public function updateorigin(Request $request)
    {
        // return $request;
        $request->validate([
            'origin' => 'required|string|max:255',
        ]);

        $origin = Origin::find($request->origin_id);
        $origin->update([
            'origin' => $request->origin,
        ]);

        return redirect()->back()->with('success', 'Origin updated successfully!');
    }

    public function deleteorigin($id)
    {
        $origin = Origin::find($id);
        $origin->delete();

        return redirect()->back()->with('success', 'Origin deleted successfully!');
    }
}
