<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TestCollection extends ResourceCollection
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
            'data' => $this->collection->map(function ($test){
                return [
                    'id' => $test->id,
                    'testname' => $test->testname,
                    'average' => $test->average,
                    'percentage' => $test->percentage,
                    'status' => $test->status,
                    'subject' => new SubjectResource($test->classSubject->subject),
                    'date' => Carbon::createFromFormat('Y-m-d H:i:s',$test->updated_at)->diffForHumans()
                ];
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
