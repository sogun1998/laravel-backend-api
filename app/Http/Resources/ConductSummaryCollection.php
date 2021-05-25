<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ConductSummaryCollection extends ResourceCollection
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
            'data' => $this->collection->map(function ($conduct){
                return [
                    'id' => $conduct->id,
                    'semester' => $conduct->semester,
                    'mark' => $conduct->mark,
//                    'mark_id' => new MarkResource(Mark::find($score->mark_id)),
//                    'status' => $score->status,
                    'comment' => $conduct->comment,
//                    'student' => $conduct->achievement->student,
//                    'subject'=> $conduct->achievement->classSubject->subject,
////                    'subject' => new SubjectResource($test->classSubject->subject),
//                    'diff_now' => $conduct->date,
                    'date' => Carbon::createFromFormat('Y-m-d H:i:s',$conduct->created_at)->diffForHumans()
                ];
            }),
//            'links' => [
//                'self' => 'link-value',
//            ],
        ];
    }
}
