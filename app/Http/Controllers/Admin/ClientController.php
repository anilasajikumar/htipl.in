<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use Illuminate\Http\Request;
use Toastr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.client.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.client.create');
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
        'name'=>'required|max:255',
        'logo'=>'mimes:jpeg,jpg,png,gif|required|max:2128',
      ]);

        if ($request->hasFile('logo')){
            $path = Storage::disk('public')->put('client_logo', $request->file('logo'));
        }


        $client = new Clients;
        $client->name = $request->name;
        $client->slug = Str::slug($request->name , '-');
        if ($request->hasFile('logo')){
            $client->logo = $path;
        }
        $client->save();
        Toastr::success('Client Successfully Created', 'Success');

     return redirect(route('client.index'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getdata()
    {
        $client = Clients::select('clients.*')->get();
        return Datatables::of($client)->addColumn('edit', function ($client) {
               return '<a href="'.route('client.edit',$client->id).'" class="btn btn-info btn-fw">Edit</a>';
           })
        ->addColumn('action', function ($client) {
               return '<span data-url="'.route('client.destroy',$client->id).'"class="btn btn-danger btn-fw deteting-btn">Delete</span>';
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
        $client = Clients::findOrFail($id);
        return view('admin.client.edit',compact('client'));
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
        'name'=>'required|max:255',
        'logo'=>'mimes:jpeg,jpg,png,gif|nullable|max:2128',
      ]);

        if ($request->hasFile('logo')){
            $path = Storage::disk('public')->put('client_logo', $request->file('logo'));
        }


        $client = Clients::findOrFail($id);
        $client->name = $request->name;
        $client->slug = Str::slug($request->name , '-');
        if ($request->hasFile('logo')){
            $client->logo = $path;
        }
        $client->save();
        Toastr::success('Client Successfully Updated', 'Success');

     return redirect(route('client.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Clients::findOrFail($id);
        Storage::disk('public')->delete($client->image);
        $client->delete();
        Toastr::error('Client Successfully Removed', 'Success');
        return redirect()->back();
    }
}
