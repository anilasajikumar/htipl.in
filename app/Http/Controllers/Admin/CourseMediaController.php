<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseMedia;
use App\Models\Media;
use App\Models\OnlineCourse;
use App\Models\CourseModule;

use App\Services\MediaRepository;
use Illuminate\Http\Request;

use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Toastr;
// use App\Http\Helpers\Datatable;

use Yajra\Datatables\Datatables;
class CourseMediaController extends Controller
{
    protected $mediaRepository;
     /**
     * Constructor
     * @param Request $request
     */
    public function __construct(
        MediaRepository $mediaRepository
    )
    { 
        $this->mediaRepository = $mediaRepository;
       
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.course_media.index');
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

        return view('admin.course_media.create',compact('courses','courseModules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
  public function store(Request $request)
{
    $request->validate([
        'course_module_id' => 'required|integer',
        'course_media_description' => 'required',
        'title' => 'required|string|max:255',
        'file' => 'nullable|file|mimes:pdf,mp4|max:51200',
        'link' => 'nullable|string',
        'pdf_link' => 'nullable|string',
    ]);

    // Save course media
    $courseMedia = new \App\Models\CourseMedia();
    $courseMedia->course_module_id = $request->course_module_id;
    $courseMedia->course_media_description = $request->course_media_description;
    $courseMedia->status = 1;
    $courseMedia->save();

    // Defaults
    $filename = null;
    $extension = null;
    $mimeType = null;
    $fileType = null;
    $filePath = null;
    $fileSize = null;
    $thumbnail = null;

    // File upload
    if ($request->hasFile('file')) {
        $file = $request->file('file');

        $filename = time() . '_' . $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $mimeType = $file->getMimeType();
        $fileSize = $file->getSize();

        $file->move(public_path('uploads/course_media'), $filename);
        $filePath = 'uploads/course_media/' . $filename;

        if (strpos($mimeType, 'video') !== false) {
            $fileType = 'video';
        } elseif (strpos($mimeType, 'image') !== false) {
            $fileType = 'image';
        } else {
            $fileType = 'document';
        }
    }

    // Save media
    $media = new \App\Models\Media();
    $media->course_media_id = $courseMedia->id;
    $media->title = $request->title;
    $media->file_name = $filename;
    $media->thumbnail = $thumbnail;
    $media->file_path = $filePath;
    $media->mime_type = $mimeType;
    $media->extension = $extension;
    $media->type = $fileType ?: 'document';
    $media->size = $fileSize;
    $media->link = $request->link;
    $media->pdf_link = $request->pdf_link;
    $media->status = 1;
    $media->save();

    Toastr::success('Media Successfully Created', 'Added');

    return redirect()->route('course-media.index');
}


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $course_media = CourseMedia::findOrFail($id);
        $courses = OnlineCourse::where('status','=','1')->pluck('id','course_name');
        $courseModules = CourseModule::where('status',1)->pluck('id','course_module_name');
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
        $media = Media::where('course_media_id','=',$id)->delete();
        $course_media->delete();
        Toastr::error('Media Successfully Removed', 'Success');
        return redirect()->back();
    }

    public function uploadFile(FileReceiver $receiver)
    {
        // check if the upload is success, throw exception or return response you need
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }
        // receive the file
        $save = $receiver->receive();

        // check if the upload has finished (in chunk mode it will send smaller files)
        if ($save->isFinished()) {
            // save the file and return any response you need
            return $this->mediaRepository->saveFile($save->getFile());
        }

        // we are in chunk mode, lets send the current progress
        /** @var AbstractHandler $handler */
        $handler = $save->handler();
        return response()->json([
            "done" => $handler->getPercentageDone()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getdata()
    {
        $course_media = CourseMedia::select('course_media.*','course_modules.course_module_name','media.title','media.file_name','media.extension')
        ->join('course_modules','course_media.course_module_id','course_modules.id')
        ->join('media','course_media.id','media.course_media_id')
        ->get();

        return Datatables::of($course_media)->addColumn('view', function ($course_media) {
               return '<a href="'.route('course-media.show',$course_media->id).'" class="btn btn-info btn-fw">View</a>';
           })
        ->addColumn('action', function ($course_media) {
               return '<span data-url="'.route('course-media.destroy',$course_media->id).'"class="btn btn-danger btn-fw deteting-btn">Delete</span>';
           })->rawColumns(['view','action'])
        ->addIndexColumn()
        ->make(true);
  }

   /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course_media = CourseMedia::select('course_media.*','course_modules.course_module_name','media.title','media.file_name','media.extension','media.file_path','media.link','media.pdf_link')
        ->join('course_modules','course_media.course_module_id','course_modules.id')
        ->join('media','course_media.id','media.course_media_id')
        ->where('course_media.id','=',$id)
        ->first();

        if($course_media == null){
            return abort(404);
        }

        return view('admin.course_media.media-list',compact('course_media'));
    }

}
