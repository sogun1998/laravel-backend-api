<?php

namespace App\Http\Controllers\AchievementManage;

use App\Achievement;
use App\Http\Controllers\Controller;
use App\Http\Resources\AchievementCollection;
use App\Http\Resources\MarkDetailCollection;
use App\Http\Resources\MarkDetailShortcutCollection;
use App\Http\Resources\TestCollection;
use App\MarkDetail;
use App\Test;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    //
    public function index($student,$classSubject_id)
    {
        //
        $achievement = Achievement::where('classSubject_id',$classSubject_id)->where('student_id',$student)->get()[0];
        return new MarkDetailCollection(MarkDetail::where('mark_id',$achievement->mark->id)->paginate(10));
//        return $achievement->mark->id;
    }
    public function subject_study($student)
    {
        //
        $achievement = Achievement::where('student_id',$student)->get();
//        return new MarkDetailCollection(MarkDetail::where('mark_id',$achievement->mark->id)->paginate(10));
//        return $achievement->mark->id;
        return new AchievementCollection($achievement);
    }
    public function initChart($student,$classSubject_id)
    {
        //
        $achievement = Achievement::where('classSubject_id',$classSubject_id)->where('student_id',$student)->get()[0];
        return new MarkDetailShortcutCollection(MarkDetail::where('mark_id',$achievement->mark->id)->whereIn('status', [0, 2, 3])->get());
//        return $achievement->mark->id;
    }
//    public function final_grade()
}
