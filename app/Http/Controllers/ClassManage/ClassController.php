<?php

namespace App\Http\Controllers\ClassManage;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassCollection;
use App\Http\Resources\ClassResource;
use App\Http\Resources\ParentCollection;
use App\Http\Resources\StudentCollection;
use App\Http\Resources\StudentScoreCollection;
use App\Http\Resources\UserResource;
use App\LevelTeacher;
use App\Lophoc;
use App\Student;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassController extends Controller
{
    //
    public function getTotalClass(){
        return Lophoc::count();
    }
    public function getAllClass()
    {
        //
//        return StudentResource::collection(Student::all());
        return new ClassCollection(Lophoc::paginate(10));
//        return User::all();
    }
    public function store(Request $request)
    {
        $class = Lophoc::create([
            'teacher_id'=>$request->teacher_id,
            'classname'=>$request->classname,
            'school'=>$request->school,
            'grade'=>$request->grade,
//            'canBeKeyTeacher'=> true
        ]);
        return response()->json([
            'status_code' => 200,
            'message' => "Class created successfully.",
            'data' => [
//                "class"=>$request->teacher_id,
                "class"=> new ClassResource($class),

            ],
        ]);
    }
    public function show($id)
    {
        if (Lophoc::where('id', $id)->exists()) {
            $class = Lophoc::find($id);
            return new ClassResource($class);
        } else {
            return response()->json([
                "message" => "Class not found"
            ], 404);
        }
    }
    public function update(Request $request, int $id)
    {
        //
        if (Lophoc::where('id', $id)->exists()) {
            $class = Lophoc::find($id);
            $class->classname = is_null($request->classname) ? $class->classname : $request->classname;
            $class->grade = is_null($request->grade) ? $class->grade : $request->grade;
            $class->teacher_id = is_null($request->teacher_id) ? $class->teacher_id : $request->teacher_id;
            $class->school = is_null($request->school) ? $class->school : $request->school;
            $class->save();
            $class->touch();
            return response()->json([
                "message" => "Class updated successfully",
                "class"=> new ClassResource($class)
//                "user"=>$user)
            ], 200);
        } else {
            return response()->json([
                "message" => "Class not found"
            ], 404);

        }

    }
    public function delete($id)
    {
        //
        if(Lophoc::where('id', $id)->exists()) {
            $class = Lophoc::find($id);
            $class->delete();

            return response()->json([
                "message" => "Class deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Class not found"
            ], 404);
        }
    }

    public function addStudent(Request $request)
    {
        $ids = $request->ids;
        $class_id = $request->classid;

        if(Lophoc::where('id', $class_id)->exists()) {
//            $class = Lophoc::find($class_id);
//            $class->delete();
            $students = DB::table("students")->whereIn('id',explode(",",$ids))
                ->update(array('lophoc_id' => $class_id));
            return response()->json([
                "message" => "Class updated successfully",
                "student"=> $students,
            ], 200);
        } else {
            return response()->json([
                "message" => "Class not found"
            ], 404);
        }

    }
    public function removeStudent(Request $request)
    {
        $ids = $request->ids;
//        $class_id = $request->classid;
        $students = DB::table("students")->whereIn('id',explode(",",$ids))
            ->update(array('lophoc_id' => null));

        return response()->json([
            "message" => "Class updated successfully",
            "student"=> $students,
        ], 200);
    }
    public function listStudent($id)
    {
        if (Lophoc::where('id', $id)->exists()) {
//            $class = Lophoc::find($¥id);
//            return new StudentCollection($class->students->paginate(10));
            $students = Student::where('lophoc_id', '=', $id)->paginate(15);
//            foreach ($students as $student){
//                $student -> classObj = $subjectClass;
//            }
            return new StudentCollection($students);
        } else {
            return response()->json([
                "message" => "Class not found"
            ], 404);
        }

    }
    public function listParent($id)
    {
        if (Lophoc::where('id', $id)->exists()) {
//            $class = Lophoc::find($¥id);
//            return new StudentCollection($class->students->paginate(10));
            $students = Student::where('lophoc_id', '=', $id)->get();
            $students = $students->filter(function($item) {
                return $item->parent != null;
            });
//            foreach ($students as $student){
//                $student -> classObj = $subjectClass;
//            }
            return new ParentCollection($students);
//            return $students;
        } else {
            return response()->json([
                "message" => "Class not found"
            ], 404);
        }

    }
    public function listStudentInTeachClass($id,$subjectClass)
    {
        if (Lophoc::where('id', $id)->exists()) {
//            $class = Lophoc::find($¥id);
//            return new StudentCollection($class->students->paginate(10));
            $students = Student::where('lophoc_id', '=', $id)->paginate(15);
            foreach ($students as $student){
                $student -> classObj = $subjectClass;
            }
            return new StudentScoreCollection($students);
        } else {
            return response()->json([
                "message" => "Class not found"
            ], 404);
        }

    }
    public function getListClassControl($id)
    {
        if (User::where('id', $id)->exists()) {
//            $class = Lophoc::find($id);
//            return new StudentCollection($class->students->paginate(10));
            $classes = Lophoc::where('teacher_id', '=', $id)->paginate(15);
            return new ClassCollection($classes);
        } else {
            return response()->json([
                "message" => "User not found"
            ], 404);
        }
    }

}
