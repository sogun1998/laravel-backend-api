<?php

namespace App\Http\Controllers\AccountManage;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\LevelTeacher;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
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
    public function multiDelete(Request $request){
        $ids = $request->ids;
        DB::table("users")->whereIn('id',explode(",",$ids))->delete();
        return response()->json(["message" => "Teacher deleted"]);
    }
}
