<?php

namespace App\Http\Resources;

use App\MarkDetail;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MarkRequestDetailCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        Carbon::setLocale('vi');
        return [
            'data' => $this->collection->map(function ($msg){
                return [
                    'id' => $msg->id,
                    'markDetail' => new MarkDetailResource(MarkDetail::find($msg->markDetail_id)),
                    'text' => $msg->text,
                    'class' => new AssignResource(MarkDetail::find($msg->markDetail_id)->test->classSubject),
                    'new_score' => $msg->new_score,
                    'old_score' => $msg->old_score,
//                    'status' => $score->status,
//                    'comment' => $score->comment,
//                    'student' => $score->markid->achievement->student,
//                    'subject'=> $score->test->classSubject->subject,
////                    'subject' => new SubjectResource($test->classSubject->subject),
//                    'diff_now' => Carbon::now()->diffInHours(Carbon::createFromFormat('Y-m-d H:i:s',$msg->created_at)),
                    'date' => Carbon::createFromFormat('Y-m-d H:i:s',$msg->updated_at)->diffForHumans()
                ];
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
