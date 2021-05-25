<?php

namespace App\Http\Controllers\ConductManage;

use App\Achievement;
use App\Conduct;
use App\Http\Controllers\Controller;
use App\Http\Resources\ConductCollection;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ConductController extends Controller
{
    //
    public function store(Request $request)
    {
        //
//        DB::beginTransaction();

        $student_id = $request->student_id;
        $classSubject_id = $request->classSubject_id;
        $achievement = Achievement::where('student_id',$student_id)
            ->where('classSubject_id',$classSubject_id)
            ->get();
//        if(sizeof($achievement))
        if($achievement->count() > 0) {
            $conduct = Conduct::create([
//
                'status'=>$request->comment,
//
                'mark'=>$request->mark,
                'date'=> Carbon::now(),
//
            ]);
            $conduct->achievement_id = $achievement[0]->id;
//        $test->percentage = $request->percentage;
            $conduct->save();
            $conduct->touch();

            return response()->json([
                'status_code' => 200,
                'message' => "Test created successfully.",
                'data' => [
                    "test" => $conduct,
//                "count" => $count
//            "classSubject_id" => $achievement[0]->mark

                ],
            ]);
        }
        else {
            return response()->json([
                'status_code' => 200,
                'message' => "Not search achievement",
//                'data' => [
//                    "test" => $conduct,
////                "count" => $count
////            "classSubject_id" => $achievement[0]->mark
//
//                ],
            ]);
        }
    }
    public function index($student,$classSubject_id)
    {
        //
        $achievement = Achievement::where('classSubject_id',$classSubject_id)->where('student_id',$student)->get()[0];
        return new ConductCollection(Conduct::where('achievement_id',$achievement->id)->paginate(10));
//        return $achievement->mark->id;
    }
    public function getAll($student)
    {
        $collection = collect([]);
        $achievements = Achievement::select('id')->where('student_id',$student)->get();
        foreach ($achievements as $achievement){
            $collection->push($achievement->id);
        }
//        return $collection;
        return new ConductCollection(Conduct::whereIn('achievement_id',$collection)->paginate(10));
    }
    public function average($student)
    {
        $collection = collect([]);
        $achievements = Achievement::select('id')->where('student_id',$student)->get();
        foreach ($achievements as $achievement){
            $collection->push($achievement->id);
        }
//        return $collection;
        return Conduct::whereIn('achievement_id',$collection)->avg('mark');
    }

    public function delete($id)
    {
        //
        if(Conduct::where('id', $id)->exists()) {
            $conduct = Conduct::find($id);
            $conduct->delete();

            return response()->json([
                "message" => "Conduct deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Conduct not found"
            ], 404);
        }
    }
}
