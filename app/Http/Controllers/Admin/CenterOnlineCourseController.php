<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CenterOnlineCourse;
use App\Models\Centers;
use App\Models\LimitValidityRequest;
use App\Models\OnlineCourse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Toastr;
use Yajra\Datatables\Datatables;

class CenterOnlineCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.center.course.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $course = OnlineCourse::pluck('id','course_name');
        $center = Centers::pluck('id','study_center_name');
        return view('admin.center.course.create',compact('course','center'));
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
            'course'=>['required',Rule::unique('center_online_courses','course_id')->where(function ($query) use ($request) {
    return $query->where('center_id', $request->center);
})],
            'center'=>['required',Rule::unique('center_online_courses','center_id')->where(function ($query) use ($request) {
    return $query->where('course_id', $request->course);
})],
            'validity'=>'required',
            'limit'=>'required|max:10',
        ],['course.unique' => 'This Course Already Assigned To Center']);

        $center_course = new CenterOnlineCourse;
        $center_course->course_id = $request->course;
        $center_course->center_id = $request->center;
        $center_course->validity = $request->validity;
        $center_course->limit = $request->limit;
        $center_course->save();

        Toastr::success('Course Successfully Assigned', 'Success');
     return redirect(route('center-course.index'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getdata()
    {
        $center_course = CenterOnlineCourse::select('center_online_courses.*','centers.study_center_name as center','online_courses.course_name as course')
        ->join('online_courses','center_online_courses.course_id','online_courses.id')
        ->join('centers','center_online_courses.center_id','centers.id')
        ->get();
        return Datatables::of($center_course)->addColumn('edit', function ($center_course) {
               return '<a href="'.route('center-course.edit',$center_course->id).'" class="btn btn-info btn-fw">Edit</a>';
           })
        ->addColumn('action', function ($center_course) {
               return '<span data-url="'.route('center-course.destroy',$center_course->id).'"class="btn btn-danger btn-fw deteting-btn">Delete</span>';
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
        $center_course = CenterOnlineCourse::findOrFail($id);
        $course = OnlineCourse::pluck('id','course_name');
        $center = Centers::pluck('id','study_center_name');
        return view('admin.center.course.edit',compact('center_course','course','center'));
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
            'course'=>['required',Rule::unique('center_online_courses','course_id')->ignore($id)->where(function ($query) use ($request) {
    return $query->where('center_id', $request->center);
})],
            'center'=>['required',Rule::unique('center_online_courses','center_id')->ignore($id)->where(function ($query) use ($request) {
    return $query->where('course_id', $request->course);
})],
            'validity'=>'required',
            'limit'=>'required|max:10',
        ],['course.unique' => 'This Course Already Assigned To Center',
        'center.unique' => 'This Course Already Assigned To Center']);

        $center_course = CenterOnlineCourse::findOrFail($id);
        $center_course->course_id = $request->course;
        $center_course->center_id = $request->center;
        $center_course->validity = $request->validity;
        $center_course->limit = $request->limit;
        $center_course->save();

        Toastr::success('Successfully Updated', 'Success');
     return redirect(route('center-course.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CenterOnlineCourse::findOrFail($id)->delete();
        Toastr::error('Successfully Removed', 'Success');
        return redirect()->back();
    }

    public function centerCourseRequests()
    {
        return view('admin.center.course.requests');
    }

    public function centerCourseRequestsData()
    {
        $center_course_requests = LimitValidityRequest::select('limit_validity_requests.*','centers.study_center_name','online_courses.course_name')
        ->join('center_online_courses','limit_validity_requests.center_online_courses_id','center_online_courses.id')
        ->join('online_courses','center_online_courses.course_id','online_courses.id')
        ->join('centers','center_online_courses.center_id','centers.id')
        ->where('limit_validity_requests.status','=','0')
        ->get();

        return Datatables::of($center_course_requests)->addColumn('approve', function ($center_course_requests) {
               return '<a href="'.route('center-course.requests.approve',$center_course_requests->id).'" class="btn btn-info btn-fw approve-btn">Approve</a>';
           })
        ->addColumn('reject', function ($center_course_requests) {
               return '<span data-url="'.route('center-course.requests.reject',$center_course_requests->id).'"class="btn btn-danger btn-fw reject-btn">Reject</span>';
           })->rawColumns(['approve','reject'])
        ->addIndexColumn()
        ->make(true);
    }



    public function centerCourseRequestsApprove($id)
    {
        $change_status = LimitValidityRequest::select('limit_validity_requests.*')
        ->join('center_online_courses','limit_validity_requests.center_online_courses_id','center_online_courses.id')
        ->join('online_courses','center_online_courses.course_id','online_courses.id')
        ->join('centers','center_online_courses.center_id','centers.id')
        ->where('limit_validity_requests.id','=',$id)
        ->first();

        if($change_status->old_validity != $change_status->new_validity || $change_status->old_limit != $change_status->new_limit ){

            $increase_validity_limit = CenterOnlineCourse::findOrfail($change_status->center_online_courses_id);
            $increase_validity_limit->limit = $increase_validity_limit->limit+$change_status->new_limit;
            $increase_validity_limit->validity = $change_status->new_validity;
            $increase_validity_limit->save();

            $change_status->status = '1';
            $change_status->save();
            Toastr::success('Successfully Updated', 'Success');
            return redirect()->back();

        }
    }

    public function centerCourseRequestsReject($id)
    {
        $change_status = LimitValidityRequest::findOrFail($id);
        $change_status->status = '2';
        $change_status->save();
        Toastr::error('Successfully Updated', 'Success');
        return redirect()->back();
    }


    public function centerCourseTrash()
    {
        return view('admin.center.course.trash');
    }


    public function centerCourseTrashData()
    {
        $center_course = CenterOnlineCourse::select('center_online_courses.*','centers.study_center_name as center','online_courses.course_name as course')
        ->join('online_courses','center_online_courses.course_id','online_courses.id')
        ->join('centers','center_online_courses.center_id','centers.id')
        ->onlyTrashed()
        ->get();
        return Datatables::of($center_course)->addColumn('restore', function ($center_course) {
               return '<span data-url="'.route('center-course.restore',$center_course->id).'"class="btn btn-danger btn-fw deteting-btn">Restore</span>';
           })->rawColumns(['restore'])
        ->addIndexColumn()
        ->make(true);
    }

    public function Restore($id)
    {
        CenterOnlineCourse::withTrashed()->find($id)->restore();
        return redirect(route('center-course.index'));
    }
}
