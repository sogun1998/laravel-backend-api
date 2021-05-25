<?php

namespace App\Http\Resources;

use App\Mark;
use App\Test;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ConductCollection extends ResourceCollection
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
//                    'test' => new TestResource(Test::find($score->test_id)),
                    'mark' => $conduct->mark,
//                    'mark_id' => new MarkResource(Mark::find($score->mark_id)),
//                    'status' => $score->status,
                    'comment' => $conduct->status,
                    'student' => $conduct->achievement->student,
                    'subject'=> $conduct->achievement->classSubject->subject,
//                    'subject' => new SubjectResource($test->classSubject->subject),
                    'diff_now' => $conduct->date,
                    'date' => Carbon::createFromFormat('Y-m-d H:i:s',$conduct->created_at)->diffForHumans()
                ];
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
