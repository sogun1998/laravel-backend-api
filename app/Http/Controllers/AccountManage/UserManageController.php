<?php

namespace App\Http\Controllers\AccountManage;

use App\ClassSubject;
use App\Http\Resources\AssignCollection;
use App\Http\Resources\AssignResource;
use App\Http\Resources\ClassCollection;
use App\Http\Resources\ClassResource;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\LevelTeacher;
use App\Lophoc;
use App\Student;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllUser()
    {
        //
//        return UserResource::collection(User::all());
//       return User::paginate();
        return new UserCollection(User::paginate(10));
//        return response()->json([
//            "" => "records updated successfully"
//        ], 200);
////        return User::all();
    }
    public function getTotalTeacher(){
        return User::count();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => bcrypt($request->password),

        ]);
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (User::where('id', $id)->exists()) {
            $user = User::find($id);
            return new UserResource($user);
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
        if (User::where('id', $id)->exists()) {
            $user = User::find($id);
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
                "message" => "records updated successfully"
            ], 200);
        } else {
            return response()->json([
                "message" => "Teacher not found"
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
        if(User::where('id', $id)->exists()) {
            $user = User::find($id);
            $user->delete();

            return response()->json([
                "message" => "records deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Teacher not found"
            ], 404);
        }
    }
    public function addLevelTeacher(Request $request, int $id)
    {
        if (User::where('id', $id)->exists()) {
            $user = User::find($id);
            $levelTeacher = LevelTeacher::create([
                'admin_id'=>$request->user()->id,
                'level'=>$request->level,
                'subject'=>$request->subject,
//                'grade'=>$request->grade,
                'canBeKeyTeacher'=> $request->canBeKeyTeacher,
            ]);
            $levelTeacher->canBeKeyTeacher = $request->canBeKeyTeacher;
            $user->level_id = $levelTeacher ->id;
            $user->save();
            $levelTeacher->save();
            return response()->json([
                "message" => "records updated successfully",
//                "canBeKeyTeacher" =>$levelTeacher
            ]);
        } else {
            return response()->json([
                "message" => "Teacher not found"
            ], 404);

        }
    }
    public function updateLevelTeacher(Request $request, int $id){
        if (User::where('id', $id)->exists()) {
            $user = User::find($id);
            $level_id = $user->level_id;
            if(LevelTeacher::where('id',$level_id)->exists()){
                $level = LevelTeacher::find($level_id);
                $level->level = is_null($request->level) ? $level->level : $request->level;
                $level->subject = is_null($request->subject) ? $level->subject : $request->subject;
                $level->canBeKeyTeacher = is_null($request->canBeKeyTeacher) ? $level->canBeKeyTeacher : $request->canBeKeyTeacher;
                $level->admin_id = $request->user()->id;
                $level->save();
                $level->touch();
                return response()->json([
                    "message" => " updated successfully"
                ], 200);
            }
            else {
                return response()->json([
                    "message" => "Level not found"
                ], 404);

            }
        }else {
            return response()->json([
                "message" => "Teacher not found"
            ], 404);

        }
    }
    public function upload(Request $request){
        $teachers = $request->data;
        $count = 0;
        $date  = Carbon::now();
        DB::beginTransaction();
        try {
            foreach ($teachers as $teacher) {
            $input = User::create(
                [
                    'email' => $teacher['email'],
                    'name' => $teacher['name'],
                    'password' => bcrypt($teacher['password'])
                ]
            );
            $birthday = Carbon::createFromDate($teacher['birthdayYear'], $teacher['birthdayMonth'], $teacher['birthdayDate'], 'Asia/Ho_Chi_Minh');
            $input->birthday = $birthday;
            $input->fullname = $teacher['fullname'];
            $input->gender =$teacher['gender'];
            $input->phone =$teacher['phone'];
            $input->school =$teacher['school'];
            $input->save();
            $input->touch();
            $count++;
        }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
//
        }
        return response()->json([
            "message" => "Created success",
            "Total created" => $count,
            "Date" => $birthday
            ]);

    }
    public function multiDelete(Request $request){
        $ids = $request->ids;
        DB::table("users")->whereIn('id',explode(",",$ids))->delete();
        return response()->json(["message" => "Teacher deleted"]);
    }
    public function analyze($id){
        if (User::where('id', $id)->exists()) {
            $user = User::find($id);
//            return new UserResource($user);
            $count_form_class = Lophoc::where('teacher_id',$id)->get('id');
            $count_form_students = 0;
            foreach ($count_form_class as $class){
                $count_form_student = Student::where('lophoc_id', '=', $class->id)->count();
                $count_form_students += $count_form_student;
            }
            $count_student_teach = 0;
            $classSubjects = ClassSubject::where('teacher_id',$id)->where('isActive',1)->get();
            foreach ($classSubjects as $classSubject){
                $count_student = Student::where('lophoc_id', '=', $classSubject->lophoc_id)->count();
                $count_student_teach += $count_student;
            }
            return response()->json([
                "count_form_class" => $count_form_class->count(),
                "count_form_student" => $count_form_students,
                "count_class_teach" => $classSubjects->count(),
                "demo" => new AssignCollection($classSubjects),
                "count_student_teach" =>$count_student_teach
            ],200);
        } else {
            return response()->json([
                "message" => "User not found"
            ], 404);
        }
    }
    public function teacherStatus($id){
        if (User::where('id', $id)->exists()) {
            $user = User::find($id);
            $classes = Lophoc::where('teacher_id',$id)->get();
//            $class = Lophoc::find()
            $assign = ClassSubject::where('teacher_id',$id)->where('isActive',1)->get();
            return response()->json([
                "classByKeyTeacher" => $classes,
                "classTeach" => new AssignCollection($assign),
            ],200);
        } else {
            return response()->json([
                "message" => "User not found"
            ], 404);
        }
    }
    public function countByMonth()
    {
        $users = User::select('id', 'created_at')
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


}
