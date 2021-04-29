<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SubjectCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($subject){
                return [
                    'id' => $subject->id,
                    'subjectname' => $subject->subjectname,
                    'grade' => $subject->grade,
                    'school' => $subject->school,
                    'type' => $subject->type,
                ];
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
