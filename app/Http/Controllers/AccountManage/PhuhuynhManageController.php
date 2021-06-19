<?php

namespace App\Http\Controllers\AccountManage;

use App\Http\Controllers\Controller;
use App\Http\Resources\ParentResource;
use App\Phuhuynh;
use App\Student;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PhuhuynhManageController extends Controller
{
    //
//    public function getAllStudent()
//    {
//        //

////        return StudentResource::collection(Student::all());
//        return new StudentCollection(Student::paginate(10));
////        return User::all();
//    }
//    public function getTotalStudent(){
//        return Student::count();
//    }
    public function store(Request $request)
    {
        $parent = Phuhuynh::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => bcrypt($request->password),

        ]);
        $parent->fullname = $request->fullname;
        $parent->gender = $request->gender;
        $parent->phone = $request->phone;
        $parent->student_id = $request->student_id;
        $parent->save();
        $parent->touch();
        return new ParentResource($parent);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Phuhuynh::where('id', $id)->exists()) {
            $parent = Phuhuynh::find($id);
            return new ParentResource($parent);
        } else {
            return response()->json([
                "message" => "Parent not found"
            ], 404);
        }
    }
    public function showFromStudent($id)
    {
        if (Student::where('id', $id)->exists()) {
            $student = Student::find($id);
            if($student->parent != null){
                return new ParentResource($student->parent);
            }else return response()->json([
                "data" => ""
            ], 200);
//            return new ParentResource($parent);
        } else {
            return response()->json([
                "message" => "Parent not found"
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
        if (Phuhuynh::where('id', $id)->exists()) {
            $user = Phuhuynh::find($id);
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
                "user"=> new ParentResource($user)
//                "user"=>$user)
            ], 200);
        } else {
            return response()->json([
                "message" => "Parent not found"
            ], 404);

        }

    }
    public function countByMonth()
    {
        $users = Phuhuynh::select('id', 'created_at')
            ->get()
            ->groupBy(function($date) {
                //return Carbon::parse($date->created_at)->format('Y'); // grouping by years
                return Carbon::parse($date->created_at)->format('m'); // grouping by months
            });

        $usermcount = [];
        $userArr = [];
        $month = [
            'No','Jan','Feb','Mar','Apr','May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ];
        foreach ($users as $key => $value) {
            $usermcount[(int)$key] = count($value);
        }

        for($i = 1; $i <= 12; $i++){
            if(!empty($usermcount[$i])){
                $userArr[$i] = $usermcount[$i];
            }else{
                $userArr[$i] = 0;
            }
        }
        return response()->json([
//            "data" => $usermcount,
            "data_hi" => $userArr
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//    public function delete($id)
//    {
//        //
//        if(Student::where('id', $id)->exists()) {
//            $student = Student::find($id);
//            $student->delete();
//
//            return response()->json([
//                "message" => "Student deleted"
//            ], 202);
//        } else {
//            return response()->json([
//                "message" => "Student not found"
//            ], 404);
//        }
//    }
//    public function upload(Request $request){
////
//        $students = $request->data;
//        $count = 0;
////        foreach ($students as $student) {
////            $class = Lophoc::where("classname",$student['classname'])->where("school",$student['school'])->get();
////        }
//
//        DB::beginTransaction();
//        try {
//            foreach ($students as $student) {
//                $input = Student::create(
//                    [
//                        'email' => $student['email'],
//                        'name' => $student['name'],
//                        'password' => bcrypt($student['password'])
////
//                    ]
//                );
//                $birthday = Carbon::createFromDate($student['birthdayYear'], $student['birthdayMonth'], $student['birthdayDate'], 'Asia/Ho_Chi_Minh');
//                $input->birthday = $birthday;
//                $input->fullname = $student['fullname'];
//                $input->gender =$student['gender'];
//                $input->phone =$student['phone'];
////            $input->phone =$student['phone'];
////            $input->school =$student['school'];
//                $class = Lophoc::where("classname",$student['classname'])->where("school",$student['school'])->get();
//                $input->lophoc_id = $class[0]->id;
//                $input->save();
//                $input->touch();
//
//                $count++;
////                DB::insert('insert into students (email, name, password,fullname,gender,phone) values (?, ?, ?, ?, ?, ?)', [$student['email'], $student['name'], $student['password'], $student['email'], $student['fullname'], $student['gender'], $student['phone']]);
//            }
//            DB::commit();
//        } catch (Exception $e) {
//            DB::rollBack();
//
//            throw new Exception($e->getMessage());
////            return response()->json([
////                "message" => $e->getMessage(),
//////                "Total created" => $count
////            ]);
//
//        }
//        return response()->json([
//            "message" => "Created success",
//            "Total created" => $count,
////            "class" => $class[0]->id
//        ]);
//
//
//    }
}
