<?php

namespace App\Http\Controllers\MarkDetailManage;

use App\Hictory;
use App\Http\Controllers\Controller;
use App\Http\Resources\MarkRequestCollection;
use App\Http\Resources\MarkRequestDetailCollection;
use App\MarkDetail;
use Illuminate\Http\Request;

class MarkHictoryController extends Controller
{
    //
    public function index(){
        return new MarkRequestCollection(Hictory::where('isActive',1)->orderBy('created_at', 'desc')->limit(5)->get());
    }
    public function detail(){
        return new MarkRequestDetailCollection(Hictory::where('isActive',1)->orderBy('created_at', 'desc')->paginate(10));
    }
    public function store(Request $request)
    {
        $hictory = Hictory::create([
            'markDetail_id'=>$request->markDetail_id,
            'text'=>$request->text,
            'status'=> 1,
            'isActive' => 1,
        ]);
        $hictory->old_score = $request->old_score;
        $hictory->new_score = $request->new_score;
        $markDetail = MarkDetail::find($request->markDetail_id);
        $markDetail->status = 1;
        $markDetail->save();
        $markDetail->touch();
        $hictory->save();
        $hictory->touch();
        return response()->json([
            'status_code' => 200,
            'message' => "Hictory created successfully.",
            'data' => [
                "post"=>$hictory,
            ],
        ]);
    }
    public function change(Request $request)
    {
        $hictory = Hictory::create([
            'markDetail_id'=>$request->markDetail_id,
            'text'=>$request->text,
            'status'=> 3,
            'isActive' => 0,
        ]);
        $hictory->old_score = $request->old_score;
        $hictory->new_score = $request->new_score;
        $hictory->save();
        $hictory->touch();
        return response()->json([
            'status_code' => 200,
            'message' => "Hictory created successfully.",
            'data' => [
                "post"=>$hictory,
            ],
        ]);
    }
    public function accept(Request $request)
    {
        $old = Hictory::find($request->old);
        $hictory = Hictory::create([
            'markDetail_id'=> $old->markDetail_id,
            'text'=>"Chấp nhận thay đổi ",
            'status'=>2,
            'isActive' => 0
        ]);
//        $hictory->old_score = $request->old_score;
//        $hictory->new_score = $request->new_score;
        $hictory->admin_id = $request->user()->id;
        $markDetail = MarkDetail::find($old->markDetail_id);
        $markDetail->status = 2;
        $markDetail->mark = $old->new_score;
        $markDetail->save();
        $markDetail->touch();
        $old->isActive = 0;
        $hictory->old_score = $old->old_score;
        $hictory->new_score = $old->new_score;
        $hictory->save();
        $hictory->touch();
        $old->save();
        $old->touch();
        return response()->json([
            'status_code' => 200,
            'message' => "Level created successfully.",
            'data' => [
                "post"=>$hictory,
//                "old" => $old
            ],
        ]);
    }
    public function refuse(Request $request)
    {
        $old = Hictory::find($request->old);
        $hictory = Hictory::create([
            'markDetail_id'=> $old->markDetail_id,
            'text'=>"Không hấp nhận thay đổi ",
            'status'=>0,
            'isActive' => 0
        ]);
//        $hictory->old_score = $request->old_score;
//        $hictory->new_score = $request->new_score;
        $hictory->admin_id = $request->user()->id;
        $old->isActive = 0;
//        $hictory->old_score = $old->old_score;
//        $hictory->new_score = $old->new_score;
        $markDetail = MarkDetail::find($old->markDetail_id);
        $markDetail->status = 3;
        $markDetail->save();
        $markDetail->touch();
        $hictory->save();
        $hictory->touch();
        $old->save();
        $old->touch();
        return response()->json([
            'status_code' => 200,
            'message' => "Level created successfully.",
            'data' => [
//                "post"=>$hictory,
                "old" => $old,
                "s" => $markDetail,
            ],
        ]);
    }

}
