<?php

namespace App\Http\Controllers\SubjectManage;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectResource;
use App\LevelTeacher;
use App\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $subject = Subject::create([
//            'admin_id'=>$request->user()->id,
            'subjectname'=>$request->subjectname,
//            'subject'=>$request->subject,
            'grade'=>$request->grade,
            'school'=>$request->school
//            'canBeKeyTeacher'=> true
        ]);
        return response()->json([
            'status_code' => 200,
            'message' => "Subject created successfully.",
            'data' => [
                "subject"=>$subject,
            ],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
        if (Subject::where('id', $id)->exists()) {
            $subject = Subject::find($id);
            $subject->subjectname = is_null($request->subjectname) ? $subject->subjectname : $request->subjectname;
            $subject->grade = is_null($request->grade) ? $subject->grade : $request->grade;
            $subject->type = is_null($request->type) ? $subject->type : $request->type;
//            $subject->school = is_null($request->school) ? $class->school : $request->school;
            $subject->save();
            $subject->touch();
            return response()->json([
                "message" => "Class updated successfully",
                "subject"=> new SubjectResource($subject)
//                "user"=>$user)
            ], 200);
        } else {
            return response()->json([
                "message" => "Subject not found"
            ], 404);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
