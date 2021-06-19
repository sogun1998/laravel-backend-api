<?php

namespace App\Http\Controllers\AssignManage;

use App\Achievement;
use App\ClassSubject;
use App\Http\Controllers\Controller;
use App\Http\Resources\AssignCollection;
use App\Http\Resources\AssignResource;
use App\Lophoc;
use App\Mark;
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
        return new AssignCollection(ClassSubject::where("isActive",1)->paginate(10));
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
                $class = Lophoc::where("classname",$assignment['classname'])->get();
                $subject = Subject::where("subjectname",$assignment['subjectname'])->where("school",$assignment['school'])->where("grade",$assignment['grade'])->get();
//                if($class->count() == 0){
//                    break;
//                    DB::rollBack();
////
//                    return response()->json([
//                        "message" => "Kiểm tra lại thông tin Lớp và Giáo viên",
////
//                    ]);
//                }
                $input = ClassSubject::create(
                [
                    'lophoc_id' =>$class[0]->id,
                    'subject_id'=>$subject[0]->id,
                    'teacher_id'=>$teacher[0]->id
                ]
            );
//                $input->lophoc_id = $class[0]->id;
                $input->save();
                $input->touch();
                $students = Student::where('lophoc_id',$class[0]->id)->get();
                foreach ($students as $student ){
                    $achievement = Achievement::create(
                        [
                            'student_id'=>$student->id,
                            'classSubject_id'=>$input->id,
                        ]
                    );
                    $mark = Mark::create([
                        'achievement_id' => $achievement->id,
                        'finalGrade' => 0
                    ]);
                }
                $count++;
//                DB::insert('insert into students (email, name, password,fullname,gender,phone) values (?, ?, ?, ?, ?, ?)', [$student['email'], $student['name'], $student['password'], $student['email'], $student['fullname'], $student['gender'], $student['phone']]);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());

//            if ($e instanceof ErrorException) {
//            return response()->json([
//                "message" => "Kiểm tra lại thông tin Lớp và Giáo viên",
////                "Total created" => $count
//            ]);
//        }
//            return response()->json([
//                "message" => $e->getMessage(),
////                "Total created" => $count
//            ]);

        }
        return response()->json([
            "message" => "Created success",
            "Total created" => $count,
//            "class" => $class[0]->id,
//            "birthday" => $birthday->toDateString(),
//            "teacher" => $teacher[0]->id,
//
//            "subject" => $subject[0]->id,
//            "student" => $students
        ]);


    }

    public function delete($id)
    {
        //
        if(ClassSubject::where('id', $id)->exists()) {
            $assign = ClassSubject::find($id);
            $assign->isActive = 0 ;
            $assign->save();
            $assign->touch();
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
    public function update(Request $request, $id){
        if (ClassSubject::where('id', $id)->exists()) {
            $classSubject = ClassSubject::find($id);
//            $subject->subjectname = is_null($request->subjectname) ? $subject->subjectname : $request->subjectname;
//            $subject->grade = is_null($request->grade) ? $subject->grade : $request->grade;
//            $subject->type = is_null($request->type) ? $subject->type : $request->type;
            $classSubject->teacher_id = is_null($request->teacher_id) ? $classSubject->teacher_id : $request->teacher_id;
            $classSubject->save();
            $classSubject->touch();
            return response()->json([
                "message" => "Assign updated successfully",
//                "subject"=> new SubjectResource($subject)
//                "user"=>$user)
            ], 200);
        } else {
            return response()->json([
                "message" => "Assign not found"
            ], 404);

        }
    }

}
