<?php

namespace App\Http\Controllers\MarkDetailManage;

use App\Achievement;
use App\ClassSubject;
use App\Http\Controllers\Controller;
use App\Http\Resources\MarkDetailCollection;
use App\Http\Resources\MarkDetailResource;
use App\Http\Resources\TestCollection;
use App\Mark;
use App\MarkDetail;
use App\Student;
use App\Test;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarkDetailController extends Controller
{
    //
    public function indexFromTest($test_id)
    {
        //
        return new MarkDetailCollection(MarkDetail::where('test_id',$test_id)->paginate(10));
    }
    public function update(Request $request, $id)
    {
        //
        if (MarkDetail::where('id', $id)->exists()) {
            $score = MarkDetail::find($id);
            $score->mark = is_null($request->mark) ? $score->mark : $request->mark;
            $score->comment = is_null($request->comment) ? $score->comment : $request->comment;
//            $test->type = is_null($request->type) ? $test->type : $request->type;
//            $subject->school = is_null($request->school) ? $class->school : $request->school;
            $score->status = 0;
            $score->save();
            $score->touch();
//            $score->comment = "Đã nhập điểm";
            $test = Test::find($score->test_id);
//            $average = $test->average;
            $count = 0;
            $sum = 0;
            $items = MarkDetail::where('test_id',$score->test_id)->where('status',[0,2])->get();
//            if ($sum != 0){
//                $average = (($score->mark + $average) / ($sum + 1) );
//            } else $average = $score->mark;
//            $test->average = $average;
            foreach ($items as $item){
                $sum += $item->mark;
                $count++;
            }
            $test->average = $sum / $count;
//            $score->save();
//            $score->touch();
            $count = 0;
            $sum = 0;
            $mark = Mark::find($score->mark_id);
            $items = MarkDetail::where('mark_id',$score->mark_id)->where('status',[0,2])->get();
            foreach ($items as $item){
                $sum += ($item->mark) * ($item->test->percentage);
                $count += $item->test->percentage;
            }
            $test->save();
            $test->touch();
            $mark->finalGrade = $sum / $count;
            $mark->save();
            $mark->touch();
            return response()->json([
                "message" => "Class updated successfully",
//                "count"=> $count,
//                "average" => $test->average,
//                "sum" => $sum,
                "mark"=> $score,
 //                "user"=>$user)
            ], 200);
        } else {
            return response()->json([
                "message" => "Subject not found"
            ], 404);

        }
    }
    public function show($id)
    {
        //
        if (MarkDetail::where('id', $id)->exists()) {
            $test = MarkDetail::find($id);
            return new MarkDetailResource($test);
        } else {
            return response()->json([
                "message" => "Test not found"
            ], 404);
        }
    }

}
