<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsAndEvents;
use Illuminate\Http\Request;
use Toastr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;

class NewsAndEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.news_event.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.news_event.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
        'title'=>'required|max:255',
        'image'=>'mimes:jpeg,jpg,png,gif|required|max:2128',
        'description' =>'required',
        'type' =>'required',
        'date' =>'nullable',
      ]);

        if ($request->hasFile('image')){
            $path = Storage::disk('public')->put('news_event_image', $request->file('image'));
        }


        $news_event = new NewsAndEvents;
        $news_event->type = $request->type;
        $news_event->title = $request->title;
        $news_event->slug = Str::slug($request->title , '-');
        $news_event->date = $request->date;
        if ($request->hasFile('image')){
            $news_event->image = $path;
        }
        $news_event->description = $request->description;
        $news_event->save();
        Toastr::success('NewsAndEvent Successfully Created', 'Success');

     return redirect(route('news-event.index'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getdata()
    {
        $news_event = NewsAndEvents::select('news_and_events.*')->get();
        return Datatables::of($news_event)->addColumn('edit', function ($news_event) {
               return '<a href="'.route('news-event.edit',$news_event->id).'" class="btn btn-info btn-fw">Edit</a>';
           })
        ->addColumn('action', function ($news_event) {
               return '<span data-url="'.route('news-event.destroy',$news_event->id).'"class="btn btn-danger btn-fw deteting-btn">Delete</span>';
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
        $news_event = NewsAndEvents::findOrFail($id);
        return view('admin.news_event.edit',compact('news_event'));
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
        'title'=>'required|max:255',
        'image'=>'mimes:jpeg,jpg,png,gif|nullable|max:2128',
        'description' =>'required',
        'type' =>'required',
        'date' =>'nullable',
      ]);

        if ($request->hasFile('image')){
            $path = Storage::disk('public')->put('news_event_image', $request->file('image'));
        }


        $news_event = NewsAndEvents::findOrFail($id);
        $news_event->type = $request->type;
        $news_event->title = $request->title;
        $news_event->slug = Str::slug($request->title , '-');
        $news_event->date = $request->date;
        if ($request->hasFile('image')){
            $news_event->image = $path;
        }
        $news_event->description = $request->description;
        $news_event->save();
        Toastr::success('NewsAndEvent Successfully Updated', 'Success');

     return redirect(route('news-event.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $news_event = NewsAndEvents::findOrFail($id);
        Storage::disk('public')->delete($news_event->image);
        $news_event->delete();
        Toastr::error('NewsAndEvent Successfully Removed', 'Success');
        return redirect()->back();
    }
}
