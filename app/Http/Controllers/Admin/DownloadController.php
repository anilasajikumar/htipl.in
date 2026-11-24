<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Downloads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Toastr;
use Yajra\Datatables\Datatables;

class DownloadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.downloads.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.downloads.create');
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
                'file' => 'required|mimes:pdf'
        ],['file' => 'The file must be a file of type: pdf.']);
        
        
        $name = $request->file('file')->getClientOriginalName();
        $request->file('file')->move(storage_path().'/app/public/downloads_files/', $name);  
  
        $downloads_file = new Downloads;
        $downloads_file->title = $request->title;
        $downloads_file->pdf = 'downloads_files/'.$name;
        $downloads_file->save();

        Toastr::success('Downloads Successfully Created', 'Success');
        return redirect(route('downloads.index'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getdata()
    {
        $download = Downloads::select('downloads.*')->get();

        return Datatables::of($download)->addColumn('view', function ($download) {
               return '<a href="'.route('downloads.show',$download->id).'" class="btn btn-info btn-fw">View</a>';
           })
        ->addColumn('action', function ($download) {
               return '<span data-url="'.route('downloads.destroy',$download->id).'"class="btn btn-danger btn-fw deteting-btn">Delete</span>';
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
        $download = Downloads::findOrFail($id);

        if($download == null){
            return abort(404);
        }

        return view('admin.downloads.media-list',compact('download'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // 
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
        // $this->validate($request, [
        //         'file' => 'nullable|mimes:pdf'
        // ],['file' => 'The file must be a file of type: pdf.']);
        
        
        // $name = $request->file('file')->getClientOriginalName();
        // $request->file('file')->move(storage_path().'/app/public/downloads_files/', $name);  
  
        // $downloads_file = new Downloads;
        // $downloads_file->title = $request->title;
        // $downloads_file->file = 'downloads_files/'.$name;
        // $downloads_file->save();

        // Toastr::success('Downloads Successfully Updated', 'Success');
        // return redirect(route('downloads.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $download = Downloads::findOrFail($id);
        Storage::disk('public')->delete($download->pdf);
        $download->delete();
       
        Toastr::error('Downloads Successfully Removed', 'Success');
        return redirect()->back();
    }
}
