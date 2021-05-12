<?php

namespace App\Http\Resources;

use App\Mark;
use App\Test;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MarkDetailCollection extends ResourceCollection
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
            'data' => $this->collection->map(function ($score){
                return [
                    'id' => $score->id,
                    'test' => new TestResource(Test::find($score->test_id)),
                    'mark' => $score->mark,
                    'mark_id' => new MarkResource(Mark::find($score->mark_id)),
                    'status' => $score->status,
                    'comment' => $score->comment,
                    'student' => $score->markid->achievement->student,
                    'subject'=> $score->test->classSubject->subject,
//                    'subject' => new SubjectResource($test->classSubject->subject),
                    'diff_now' => Carbon::now()->diffInHours(Carbon::createFromFormat('Y-m-d H:i:s',$score->updated_at)),
                    'date' => Carbon::createFromFormat('Y-m-d H:i:s',$score->updated_at)->diffForHumans()
                ];
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
