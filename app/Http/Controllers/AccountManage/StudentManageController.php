<?php

namespace App\Http\Controllers\AccountManage;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;

use App\Http\Resources\UserResource;
use App\Student;

use App\User;
use Illuminate\Http\Request;

class StudentManageController extends Controller
{
    public function getAllStudent()
    {
        //
        return StudentResource::collection(Student::all());
//        return User::all();
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
}
