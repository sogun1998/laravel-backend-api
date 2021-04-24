<?php

namespace App\Http\Controllers\AccountManage;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentCollection;
use App\Http\Resources\StudentResource;


use App\Lophoc;
use App\Student;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentManageController extends Controller
{
    public function getAllStudent()
    {
        //
//        return StudentResource::collection(Student::all());
        return new StudentCollection(Student::paginate(10));
//        return User::all();
    }
    public function getTotalStudent(){
        return Student::count();
    }
    public function store(Request $request)
    {
        $student = Student::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => bcrypt($request->password),

        ]);
        return new StudentResource($student);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Student::where('id', $id)->exists()) {
            $student = Student::find($id);
            return new StudentResource($student);
        } else {
            return response()->json([
                "message" => "User not found"
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        //
        if (Student::where('id', $id)->exists()) {
            $user = Student::find($id);
            $user->name = is_null($request->name) ? $user->name : $request->name;
            $user->email = is_null($request->email) ? $user->email : $request->email;
            $user->fullname = is_null($request->fullname) ? $user->fullname : $request->fullname;
            $user->phone = is_null($request->phone) ? $user->phone : $request->phone;
            $user->gender = is_null($request->gender) ? $user->gender : $request->gender;
            $user->password = is_null($request->password) ? $user->password : bcrypt($request->password);
            $user->firstLogin = is_null($request->firstLogin) ? $user->firstLogin : $request->firstLogin;

            $user->save();
            $user->touch();
            return response()->json([
                "message" => "Student updated successfully",
                "user"=> new StudentResource($user)
//                "user"=>$user)
            ], 200);
        } else {
            return response()->json([
                "message" => "Student not found"
            ], 404);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
        if(Student::where('id', $id)->exists()) {
            $student = Student::find($id);
            $student->delete();

            return response()->json([
                "message" => "Student deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Student not found"
            ], 404);
        }
    }
    public function upload(Request $request){
//
        $students = $request->data;
        $count = 0;
//        foreach ($students as $student) {
//            $class = Lophoc::where("classname",$student['classname'])->where("school",$student['school'])->get();
//        }

        DB::beginTransaction();
        try {
            foreach ($students as $student) {
                $input = Student::create(
                [
                    'email' => $student['email'],
                    'name' => $student['name'],
                    'password' => bcrypt($student['password'])
//
                ]
            );
            $input->fullname = $student['fullname'];
            $input->gender =$student['gender'];
            $input->phone =$student['phone'];
//            $input->phone =$student['phone'];
//            $input->school =$student['school'];
            $class = Lophoc::where("classname",$student['classname'])->where("school",$student['school'])->get();
            $input->lophoc_id = $class[0]->id;
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
//            "class" => $class[0]->id
        ]);


    }
    public function multiDelete(Request $request){
        $ids = $request->ids;
        DB::table("students")->whereIn('id',explode(",",$ids))->delete();
        return response()->json(["message" => "Student deleted"]);
    }

    public function search(Request $request)
    {
//        $student = Student::query()
//            ->fullname($request->keyword)
//            ->name($request->keyword);

        $student = Student::where('fullname', 'LIKE','%'.$request->keyword.'%')
            ->where('lophoc_id', '=',null)
            ->get();
        return response()->json([
//            "message" => "Class updated successfully",
            "student"=> $student,
            "count" => $student->count()
        ], 200);
    }

}
