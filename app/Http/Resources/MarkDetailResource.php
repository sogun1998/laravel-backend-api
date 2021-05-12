<?php

namespace App\Http\Resources;

use App\Mark;
use App\Test;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class MarkDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'test' => new TestResource(Test::find($this->test_id)),
            'mark' => $this->mark,
            'mark_id' => new MarkResource(Mark::find($this->mark_id)),
            'status' => $this->status,
            'comment' => $this->comment,
            'student' => $this->markid->achievement->student,
            'subject'=> $this->test->classSubject->subject,
//                    'subject' => new SubjectResource($test->classSubject->subject),
            'date' => Carbon::createFromFormat('Y-m-d H:i:s',$this->updated_at)->toDateString()
        ];
    }
}
