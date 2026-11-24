<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\StudyCenterPasswordSendMail;
use App\Models\Centers;
use App\Models\Location;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Toastr;
use Yajra\Datatables\Datatables;
use Mail;

class CenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.center.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $location = Location::pluck('id','location');
        return view('admin.center.create',compact('location'));
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
            'study_center_name' => 'required|max:100',
            'study_center_contact_person' => 'required|max:100',
            'study_center_email' => 'required|email|max:255|unique:centers',
            'study_center_mobile' => 'required|min:6|max:16|unique:centers',
            'study_center_address' =>'required|max:255',
            'pincode' => 'required',
            'location' => 'required',
            'logo' => 'mimes:jpeg,jpg,png|required|max:2128',
        ]);

        // save logo
        if ($request->hasFile('logo')){
            $path = Storage::disk('public')->put('study_center_logo', $request->file('logo'));
        }
        // end


        // generate a id for centers
        $check_null = Centers::withTrashed()->get();
        if($check_null->isEmpty()){
        $study_center_id = 'ICRQCN1098';
      }
      else{
        $latest = Centers::withTrashed()->latest()->first();
        $study_center_id = ++$latest->study_center_id;
      }
      // end

        $center = new Centers;
        $center->study_center_id = $study_center_id;
        $center->study_center_name = $request->study_center_name;
        $center->study_center_contact_person = $request->study_center_contact_person;
        $center->study_center_email = $request->study_center_email;
        $center->study_center_mobile = $request->study_center_mobile;
        $center->study_center_address = $request->study_center_address;
        $center->pincode = $request->pincode;
        $center->location_id = $request->location;
        if ($request->hasFile('logo')){
        $center->logo = $path;
        }
        $password = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", 8)), 0, 8);
        $center->password = Hash::make($password);
        $center->save();

        $mail = $request->study_center_email;
        Mail::to($mail)->send(new StudyCenterPasswordSendMail($center, $password));

        Toastr::success('Center Successfully Created', 'Success');
     return redirect(route('center.index'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function getdata()
    {
        $center = Centers::select('centers.*','locations.location')
        ->join('locations','centers.location_id','locations.id')
        ->get();
        return Datatables::of($center)->addColumn('change-password', function ($center) {
               return '<a href="'.route('center.password',$center->id).'" class="btn btn-dark btn-fw">Change Password</a>';
           })->addColumn('edit', function ($center) {
               return '<a href="'.route('center.edit',$center->id).'" <i class="fas fa-edit"></i></a>';
           })
        ->addColumn('action', function ($center) {
               return '<span data-url="'.route('center.destroy',$center->id).'"<i class="fas fa-trash deteting-btn"></i>';
           })->rawColumns(['change-password','edit','action'])
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
        $location = Location::pluck('id','location');
        $center = Centers::findOrFail($id);
        return view('admin.center.edit',compact('location','center'));
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
            'study_center_name' => 'required|max:100',
            'study_center_contact_person' => 'required|max:100',
            'study_center_email' => 'required|email|max:255|unique:centers,study_center_email,'.$id,
            'study_center_mobile' => 'required|min:6|max:16|unique:centers,study_center_mobile,'.$id,
            'study_center_address' =>'required|max:255',
            'pincode' => 'required',
            'location' => 'required',
            'logo' => 'mimes:jpeg,jpg,png|max:2128',
        ]);

        // save logo
        if ($request->hasFile('logo')){
            $path = Storage::disk('public')->put('study_center_logo', $request->file('logo'));
        }
        // end

        $center = Centers::findOrFail($id);
        $center->study_center_name = $request->study_center_name;
        $center->study_center_contact_person = $request->study_center_contact_person;
        $center->study_center_email = $request->study_center_email;
        $center->study_center_mobile = $request->study_center_mobile;
        $center->study_center_address = $request->study_center_address;
        $center->pincode = $request->pincode;
        $center->location_id = $request->location;
        if ($request->hasFile('logo')){
        $center->logo = $path;
        }
        $center->save();

        Toastr::success('Center Successfully Updated', 'Success');
     return redirect(route('center.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $center = Centers::findOrFail($id);
        Storage::disk('public')->delete($center->logo);
        $center->delete();
        Toastr::error('Center Successfully Removed', 'Success');
        return redirect()->back();
    }

    public function viewDeletedCenters()
    {
        return view('admin.center.deleted_centers');
    }

    public function getDeletedCentersData()
    {
        $center = Centers::onlyTrashed()
        ->select('centers.*','locations.location')
        ->join('locations','centers.location_id','locations.id')
        ->get();
        return Datatables::of($center)->addColumn('restore', function ($center) {
               return '<span data-url="'.route('center.restore',$center->id).'"class="btn btn-danger btn-fw deteting-btn">Restore</span>';
           })->rawColumns(['restore'])
        ->addIndexColumn()
        ->make(true);
    }

    public function Restore($id)
    {
        Centers::withTrashed()->find($id)->restore();
        /**
        send new password to mail
        */
        $center = Centers::findOrFail($id);
        $password = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", 8)), 0, 8);
        $center->password = Hash::make($password);
        $mail = $center->study_center_email;
        Mail::to($mail)->send(new StudyCenterPasswordSendMail($center, $password));
        return redirect(route('center.index'));
    }

    public function CenterPassword($id)
    {
        $center_id = $id;
        return view('admin.center.change_password',compact('center_id'));
    }

    public function changeCenterPassword(Request $request, $id)
    {
        $this->validate($request, [
        'password' => 'required|confirmed|min:6|max:12',
     ]);
    
        $center = Centers::findOrFail($id);
        $center->password = Hash::make($request['password']);
        $center->save();

        Toastr::success('Password Successfully Changed', 'Success');
        return Redirect(route('center.index'));
    }
}
