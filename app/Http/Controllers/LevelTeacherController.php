<?php

namespace App\Http\Controllers;

use App\LevelTeacher;
use App\Post;
use Illuminate\Http\Request;

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
        //
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
}