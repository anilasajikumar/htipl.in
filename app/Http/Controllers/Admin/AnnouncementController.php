<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcement = Announcement::first();
        return view('admin.announcement.index', compact('announcement'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'text'   => 'required|string|max:255',
            'status' => 'nullable|boolean',
        ]);

        Announcement::updateOrCreate(
            ['id' => 1],
            [
                'text'   => $request->text,
                'status' => $request->status ?? 0,
            ]
        );

        return redirect()->back()->with('success', 'Announcement updated successfully.');
    }
}
