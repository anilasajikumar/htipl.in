<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseMedia;
use App\Models\CourseModule;
use App\Models\MediaLinks;
use App\Models\OnlineCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Toastr;
use Yajra\Datatables\Datatables;

class MediaLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.media_link.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = OnlineCourse::where('status','=','1')->pluck('id','course_name');
        $courseModules = CourseModule::where('status',1)->pluck('id','course_module_name');

        $max_order = MediaLinks::max('order');

        if($max_order != null){
        $order = ++$max_order;
        }
        else
        {
            $order = "1";
        }

        return view('admin.media_link.create',compact('courses','courseModules','order'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        
        $this->validate($request, [
        'course_module_id' => 'required|integer',
        'course_media_description' => 'required',
        'title' => 'required',
        'link' => 'nullable|string',
        'pdf_link' => 'nullable|string',
    ]);

    // ✅ Step 1: Save to course_media table
    $courseMedia = new \App\Models\CourseMedia;
    $courseMedia->course_module_id = $request->input('course_module_id');
    $courseMedia->course_media_description = $request->input('course_media_description');
    $courseMedia->status = 1;
    $courseMedia->save();

    // Prepare default file variables
    $filename = '';
    $extension = '';
    $mimeType = '';
    $fileType = '';
    $filePath = '';
    $fileSize = '';
    $thumbnail = '';

    // ✅ Step 2: Handle file upload (if exists)
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $mimeType = $file->getMimeType();
        $fileSize = $file->getSize();
        $filePath = 'uploads/course_media/' . $filename;

        // Move file to public/uploads/course_media
        $file->move(public_path('uploads/course_media'), $filename);

        // Determine file type manually (no str_contains)
        if (strpos($mimeType, 'video') !== false) {
            $fileType = 'video';
        } elseif (strpos($mimeType, 'image') !== false) {
            $fileType = 'image';
        } elseif (strpos($mimeType, 'pdf') !== false || strpos($mimeType, 'doc') !== false) {
            $fileType = 'document';
        } else {
            $fileType = 'document';
        }
    }

    // ✅ Step 3: Save to media table
    $media = new \App\Models\Media;
    $media->course_media_id = $courseMedia->id;
    $media->title = $request->input('title');
    $media->file_name = $filename;
    $media->thumbnail = $thumbnail;
    $media->file_path = $filePath;
    $media->mime_type = $mimeType;
    $media->extension = $extension;
    $media->type = $fileType ?? 'image';
    $media->size = $fileSize;
    $media->link = $request->input('link');
    $media->pdf_link = $request->input('pdf_link');
    $media->status = 1;
    $media->save();

        Toastr::success('Media Successfully Created', 'Success');
        return redirect(route('media-link.index'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getdata()
    {
        $media_link = CourseMedia::select('course_media.*','course_modules.course_module_name','media_links.title','media_links.video_url','media_links.video_type','media_links.order')
        ->join('course_modules','course_media.course_module_id','course_modules.id')
        ->join('media_links','course_media.id','media_links.course_media_id')
        ->get();

        return Datatables::of($media_link)->addColumn('edit', function ($media_link) {
               return '<a href="'.route('media-link.edit',$media_link->id).'" class="btn btn-info btn-fw">Edit</a>';
           })
        ->addColumn('action', function ($media_link) {
               return '<span data-url="'.route('media-link.destroy',$media_link->id).'"class="btn btn-danger btn-fw deteting-btn">Delete</span>';
           })->rawColumns(['edit','action'])
        ->addIndexColumn()
        ->make(true);

  }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $media_link = CourseMedia::select('course_media.*','media_links.title','media_links.video_url','media_links.video_type','media_links.order','online_courses.id as course_id')
        ->join('course_modules','course_media.course_module_id','course_modules.id')
        ->join('online_courses','course_modules.course_id','online_courses.id')
        ->join('media_links','course_media.id','media_links.course_media_id')
        ->where('course_media.id','=',$id)
        ->first();

        $courses = OnlineCourse::where('status','=','1')->pluck('id','course_name');
        $courseModules = CourseModule::where('status',1)->pluck('id','course_module_name');

        return view('admin.media_link.edit',compact('media_link','courses','courseModules'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'course_module_id'=>'required',
            'course_media_description'=>'required',
            'title'=>'required',
        ]);

        $course_media = CourseMedia::findOrFail($id);

        if($course_media == null){
            return abort(404);
        }

        $course_media->course_module_id = $request->course_module_id;
        $course_media->course_media_description = $request->course_media_description;
        $course_media->save();


        $media_link = MediaLinks::where('course_media_id','=',$course_media->id)->first();

        // swap order
        $check_order = MediaLinks::where('order','=', $request->order)->first();
        if($check_order != null){
            $max_order = MediaLinks::max('order');
            $check_order->order = $media_link->order;
            $check_order->save();
        }
        // end
        
        $media_link->course_media_id = $course_media->id;
        $media_link->title = $request->title;
        $media_link->video_url = $request->video_url;
        $media_link->video_type = $request->video_type;
        $media_link->order = $request->order;
        $media_link->save();


        Toastr::success('Media Successfully Updated', 'Success');
        return redirect(route('media-link.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course_media = CourseMedia::findOrFail($id);
        MediaLinks::where('course_media_id','=',$course_media->id)->first()->delete();
        $course_media->delete();
        Toastr::error('Media Successfully Removed', 'Success');
        return redirect()->back();
    }
}
