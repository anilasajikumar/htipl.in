<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Placement;
use Illuminate\Http\Request;
use App\Models\PlacementApplication;

class PlacementController extends Controller
{
    public function index()
    {
        $placements = Placement::latest()->get();
        return view('admin.placement.index', compact('placements'));
    }

    public function create()
    {
        return view('admin.placement.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_name'     => 'required',
            'experience'    => 'required',
            'company'       => 'required',
            'salary'        => 'required',
            'qualification' => 'required',
        ]);

        Placement::create($request->all());

        return redirect()->route('placements.index')->with('success', 'Placement created successfully.');
    }

    public function edit($id)
    {
        $placement = Placement::findOrFail($id);
        return view('admin.placement.edit', compact('placement'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'post_name'     => 'required',
            'experience'    => 'required',
            'company'       => 'required',
            'salary'        => 'required',
            'qualification' => 'required',
        ]);

        $placement = Placement::findOrFail($id);
        $placement->update($request->all());

        return redirect()->route('placements.index')->with('success', 'Placement updated successfully.');
    }

    public function destroy($id)
    {
        $placement = Placement::findOrFail($id);
        $placement->delete();

        return redirect()->route('placements.index')->with('success', 'Placement deleted successfully.');
    }
    
    public function report()
    {
        // Fetch newest applications first
        $applications = PlacementApplication::with('placement')
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('admin.placement.applications_report', compact('applications'));
    }
}

