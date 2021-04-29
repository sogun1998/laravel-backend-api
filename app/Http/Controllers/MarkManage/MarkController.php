<?php

namespace App\Http\Controllers\MarkManage;

use App\Achievement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MarkController extends Controller
{
    //
    public function score(Request $request){
        $studentid = $request->studentid;
        $classSubject = $request->classSubject;
        $achievement = Achievement::where("student_id",$studentid)
//            ->where("birthday",$birthday->toDateString())
            ->get();

    }
}
