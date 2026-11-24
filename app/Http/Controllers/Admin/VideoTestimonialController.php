<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VideoTestimonial;
use Illuminate\Http\Request;

class VideoTestimonialController extends Controller
{
    public function index()
    {
        $videos = VideoTestimonial::latest()->get();
        return view('admin.video_testimonial.index', compact('videos'));
    }

    public function create()
    {
        return view('admin.video_testimonial.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'video_link' => 'required|url',
        ]);

        VideoTestimonial::create($request->all());

        return redirect()->route('video-testimonial.index')
            ->with('success','Video testimonial added');
    }

    public function destroy($id)
    {
        VideoTestimonial::findOrFail($id)->delete();
        return back()->with('success','Deleted successfully');
    }
}
