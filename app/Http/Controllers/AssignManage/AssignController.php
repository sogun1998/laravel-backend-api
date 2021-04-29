<?php

namespace App\Http\Controllers\AssignManage;

use App\ClassSubject;
use App\Http\Controllers\Controller;
use App\Http\Resources\AssignCollection;
use App\Http\Resources\AssignResource;
use App\Lophoc;
use App\Student;
use App\Subject;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssignController extends Controller
{
    //
//    public function
    public function index()
    {
        //
        return new AssignCollection(ClassSubject::paginate(10));
    }
    public function upload(Request $request){
//
        $assignments = $request->data;
        $count = 0;
//        foreach ($students as $student) {
//            $class = Lophoc::where("classname",$student['classname'])->where("school",$student['school'])->get();
//        }

        DB::beginTransaction();
        try {
            foreach ($assignments as $assignment ) {
                $birthday = Carbon::createFromDate($assignment['birthdayYear'], $assignment['birthdayMonth'], $assignment['birthdayDate'], 'Asia/Ho_Chi_Minh');
                $teacher = User::where("fullname",$assignment['fullname'])
                    ->where("birthday",$birthday->toDateString())
                    ->get();
                $class = Lophoc::where("classname",$assignment['classname'])->where("school",$assignment['school'])->get();
                $subject = Subject::where("subjectname",$assignment['subjectname'])->where("school",$assignment['school'])->where("grade",$assignment['grade'])->get();
              $input = ClassSubject::create(
                [
                    'lophoc_id' =>$class[0]->id,
                    'subject_id'=>$subject[0]->id,
                    'teacher_id'=>$teacher[0]->id
//                    'fullname' => $teacher['fullname'],
//                    'gender' => $teacher['gender'],
//                    'phone' => $teacher['phone'],
//                    'school' => $teacher['school']
                ]
            );
//                $input->lophoc_id = $class[0]->id;
                $input->save();
                $input->touch();
                $count++;
//                DB::insert('insert into students (email, name, password,fullname,gender,phone) values (?, ?, ?, ?, ?, ?)', [$student['email'], $student['name'], $student['password'], $student['email'], $student['fullname'], $student['gender'], $student['phone']]);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
//            return response()->json([
//                "message" => $e->getMessage(),
////                "Total created" => $count
//            ]);

        }
        return response()->json([
            "message" => "Created success",
            "Total created" => $count,
//            "class" => $class,
//            "birthday" => $birthday->toDateString(),
//            "teacher" => $teacher[0]->birthday,
//
//            "subject" => $subject
        ]);


    }

    public function delete($id)
    {
        //
        if(ClassSubject::where('id', $id)->exists()) {
            $student = ClassSubject::find($id);
            $student->delete();

            return response()->json([
                "message" => "Relative deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Relative not found"
            ], 404);
        }
    }
    public function show($id)
    {
        if (ClassSubject::where('id', $id)->exists()) {
            $assign = ClassSubject::find($id);
            return new AssignResource($assign);
        } else {
            return response()->json([
                "message" => "Class not found"
            ], 404);
        }
    }
//    public function update(Request $request, $id){
//        if (ClassSubject::where('id', $id)->exists()) {
//            $classSubject = ClassSubject::find($id);
////            $subject->subjectname = is_null($request->subjectname) ? $subject->subjectname : $request->subjectname;
////            $subject->grade = is_null($request->grade) ? $subject->grade : $request->grade;
////            $subject->type = is_null($request->type) ? $subject->type : $request->type;
////            $subject->school = is_null($request->school) ? $class->school : $request->school;
//            if(!is_null($request->subjectname)){
//                $subject = Subject::where("subjectname",$request->subjectname)->where("school",$assignment['school'])->get();
//            }
//            $classSubject->save();
//            $classSubject->touch();
//            return response()->json([
//                "message" => "Class updated successfully",
////                "subject"=> new SubjectResource($subject)
////                "user"=>$user)
//            ], 200);
//        } else {
//            return response()->json([
//                "message" => "Subject not found"
//            ], 404);
//
//        }
//    }

}
