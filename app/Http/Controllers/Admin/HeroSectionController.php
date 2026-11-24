<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use Illuminate\Http\Request;

class HeroSectionController extends Controller
{
    public function index()
{
    return view('admin.sliders.index');
}

public function data()
{
    return datatables()->of(HeroSection::query())
        ->addColumn('edit', function ($row) {
            return '<a href="'.route('hero.edit',$row->id).'" class="btn btn-sm btn-primary">Edit</a>';
        })
        ->addColumn('action', function ($row) {
            return '<button class="btn btn-sm btn-danger deleting-btn"
                    data-url="'.route('hero.destroy',$row->id).'">
                    Delete</button>';
        })
        ->rawColumns(['edit','action'])
        ->make(true);
}


    /* ======================
     |  CREATE PAGE
     ====================== */
    public function create()
    {
        return view('admin.sliders.create');
    }

    /* ======================
     |  STORE
     ====================== */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'background_image' => 'required|image|mimes:jpg,jpeg,png,webp',
        ]);

        $hero = new HeroSection();

        $this->saveHero($hero, $request);

        return redirect()->route('hero.index')
            ->with('success', 'Hero Section Created Successfully');
    }

    /* ======================
     |  EDIT PAGE
     ====================== */
    public function edit($id)
    {
        $hero = HeroSection::findOrFail($id);
        return view('admin.sliders.create', compact('hero'));
    }

    /* ======================
     |  UPDATE
     ====================== */
    public function update(Request $request, $id)
    {
        $hero = HeroSection::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'background_image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        $this->saveHero($hero, $request);

        return redirect()->route('hero.index')
            ->with('success', 'Hero Section Updated Successfully');
    }

    /* ======================
     |  DELETE
     ====================== */
    public function destroy($id)
    {
        $hero = HeroSection::findOrFail($id);

        if ($hero->background_image && file_exists(public_path($hero->background_image))) {
            unlink(public_path($hero->background_image));
        }

        $hero->delete();

        return redirect()->route('hero.index')
            ->with('success', 'Hero Section Deleted Successfully');
    }

    /* ======================
     |  COMMON SAVE METHOD
     ====================== */
    private function saveHero(HeroSection $hero, Request $request)
    {
        if ($request->hasFile('background_image')) {

            // delete old image
            if ($hero->background_image && file_exists(public_path($hero->background_image))) {
                unlink(public_path($hero->background_image));
            }

            $image = $request->file('background_image');
            $name = time().'_'.$image->getClientOriginalName();
            $image->move(public_path('uploads/hero'), $name);

            $hero->background_image = 'uploads/hero/'.$name;
        }

        $hero->title = $request->title;
        $hero->subtitle = $request->subtitle;
        $hero->status = $request->status ?? 1;
        $hero->save();
    }
}
