<?php

namespace App\Http\Controllers\TestManage;

use App\Achievement;
use App\ClassSubject;
use App\Http\Controllers\Controller;
use App\Http\Resources\TestCollection;
//use App\Lophoc;
use App\Http\Resources\TestResource;
use App\MarkDetail;
use App\Test;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    //
    public function index($classSubject_id)
    {
        //
        return new TestCollection(Test::where('classSubject_id',$classSubject_id)->paginate(10));
    }
    public function store(Request $request)
    {
        //
//        DB::beginTransaction();
        $test = Test::create([
//            'admin_id'=>$request->user()->id,
            'testname'=>$request->testname,
//            'subject'=>$request->subject,
            'percentage'=>$request->percentage,
            'classSubject_id'=> $request->classSubject_id,
//            'school'=>$request->school,
//            'type'=>$request->type
//            'canBeKeyTeacher'=> true
        ]);
        $test->percentage = $request->percentage;
        $test->save();
        $test->touch();
        $classSubject = ClassSubject::where('id',$request->classSubject_id)->get();
        $students = Student::where('lophoc_id',$classSubject[0]->lophoc_id) -> get();
        $count = 0;
        foreach ($students as $student){
            $achievement = Achievement::where('student_id',$student->id)
                ->where('classSubject_id',$request->classSubject_id)
                ->get();
            $markDetail = MarkDetail::create([
                'test_id'=>$test->id,
            'mark_id'=>$achievement[0]->mark->id,
            'status'=> 5,
            'comment'=>"Score is created",
//            'update'=> $request->classSubject_id,
////            'school'=>$request->school,
////            'type'=>$request->type
            ]);
            $count++;
        }

        return response()->json([
            'status_code' => 200,
            'message' => "Test created successfully.",
            'data' => [
                "test"=>$test,
                "count" => $count
//            "classSubject_id" => $achievement[0]->mark

            ],
        ]);
    }
    public function show($id)
    {
        //
        if (Test::where('id', $id)->exists()) {
            $test = Test::find($id);
            return new TestResource($test);
        } else {
            return response()->json([
                "message" => "Test not found"
            ], 404);
        }
    }
    public function update(Request $request, $id)
    {
        //
        if (Test::where('id', $id)->exists()) {
            $test = Test::find($id);
            $test->testname = is_null($request->testname) ? $test->testname : $request->testname;
            $test->percentage = is_null($request->percentage) ? $test->percentage : $request->percentage;
//            $test->type = is_null($request->type) ? $test->type : $request->type;
//            $subject->school = is_null($request->school) ? $class->school : $request->school;
            $test->save();
            $test->touch();
            return response()->json([
                "message" => "Class updated successfully",
                "subject"=> new TestResource($test)
//                "user"=>$user)
            ], 200);
        } else {
            return response()->json([
                "message" => "Subject not found"
            ], 404);

        }
    }
    public function delete($id)
    {
        //
        if(Test::where('id', $id)->exists()) {
            $test = Test::find($id);
            $markDetails = MarkDetail::where('test_id',$test->id)->get();
            foreach ($markDetails as $markDetail){
                $markDetail->status = 4;
                $markDetail->comment = "Score is deleted";
//                $markDetail->delete();
                $markDetail->save();
            }
            $test->status = 0;
            $test->save();
            return response()->json([
                "message" => "Test deleted",
//                "markDetail" => $markDetails
            ], 202);
        } else {
            return response()->json([
                "message" => "Test not found"
            ], 404);
        }
    }
}
