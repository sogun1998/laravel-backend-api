<?php

//namespace App\Http\Controllers;
namespace App\Http\Controllers\LevelManage;
use App\Http\Controllers\Controller;
use App\Http\Resources\LevelResource;
use App\Http\Resources\LevelTeacherCollection;
use App\Http\Resources\TeacherWithLevelCollection;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\LevelTeacher;
use App\Post;
use App\Student;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LevelTeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll(Request $request)
    {
        return response()->json([
            'status_code' => 200,
            'message' => "All level retrieved successfully.",
            'data' => [
                "post"=>$request->user()->levels()->get(),
            ],
        ]);


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
        $level = LevelTeacher::create([
            'admin_id'=>$request->user()->id,
            'level'=>$request->level,
            'subject'=>$request->subject,
            'grade'=>$request->grade,
            'canBeKeyTeacher'=> true
        ]);
        return response()->json([
            'status_code' => 200,
            'message' => "Level created successfully.",
            'data' => [
                "post"=>$level,
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $query = $request->user()->levels()->where('id',$request['level_id'])->first();

        if(empty($query)){
            return response()->json([
                'status_code' => 404,
                'message' => "Post not found.",
                'data' => [

                ],
            ]);
        }

        //DELETING ROW
        $query->delete();
        return response()->json([
            'status_code' => 200,
            'message' => "Post removed successfully.",
            'data' => [

            ],
        ]);
    }
    public function findLevel(Request $request)
    {
//        $level = LevelTeacher::query();
//        $level= DB::table('level_teachers')
//            ->where('subject', 'like', '%' . $request->subject . '%')
//            ->get();
        if ($request->has('level')) {
            $level= DB::table('level_teachers')
            ->where('level', 'like', '%' . $request->level . '%')
            ->get();
        }
        if ($request->has('subject')) {
            $level= DB::table('level_teachers')
            ->where('subject', 'like', '%' . $request->subject . '%')
            ->get();
        }
//        if ($request->has('grade')) {
//            $level->where('grade', 'LIKE', '%' . $request->grade . '%');
//        }
        if($level->count()>0)
//            return new LevelResource($level->get());

            return response()->json([

//                'User' => LevelTeacher::find($level[0]->id)->teachers,
            'Teacher' => new LevelTeacherCollection($level)
            ],200);
        else
        return response()->json([
            'status_code' => 404,
            'message' => "Level not found",
        ]);
//        return response()->json([
////
//                'User' =>  LevelTeacher::find($level[0]->id)->teachers,
//            ],200);
    }
    public function teccherCanbeKey(){
        $users = DB::table('users')
            ->whereNotNull('level_id')->get();
//        $users = User::where('id', 1)->get();
        $teacher = $users->reject(function ($value, $key) {
            if(User::find($value->id)->level->canBeKeyTeacher !== "Có")
            return $value;
        });
        return response()->json([

            'User' => new TeacherWithLevelCollection($teacher),
//            'User' => $teacher,
        ],200);
    }

}
