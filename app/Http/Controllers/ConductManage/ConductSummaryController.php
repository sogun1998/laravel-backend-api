<?php

namespace App\Http\Controllers\ConductManage;

use App\Achievement;
use App\Conduct;
use App\ConductSummary;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ConductSummaryController extends Controller
{
    //
    public function store(Request $request)
    {
        //
//        DB::beginTransaction();

        $student_id = $request->student_id;
//        $classSubject_id = $request->classSubject_id;
//        $achievement = Achievement::where('student_id',$student_id)
//            ->where('classSubject_id',$classSubject_id)
//            ->get();
////        if(sizeof($achievement))
//        if($achievement->count() > 0) {
            $conduct = ConductSummary::create([
//
                'comment'=>$request->comment,
                'semester' => $request->semester,
                'mark'=>$request->mark,
                'student_id'=> $student_id
//                'date'=> Carbon::now(),
//
            ]);
//            $conduct->achievement_id = $achie?vement[0]->id;
//        $test->percentage = $request->percentage;
            $conduct->save();
            $conduct->touch();

            return response()->json([
                'status_code' => 200,
                'message' => "Conduct Summary created successfully.",
                'data' => [
                    "conduct" => $conduct,
//                "count" => $count
//            "classSubject_id" => $achievement[0]->mark

                ],
            ]);

    }
}
