<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AchievementCollection extends ResourceCollection
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
            'data' => $this->collection->map(function ($achievement){
                return [
                    'id' => $achievement->id,
                    'mark' => new MarkResource($achievement->mark),
                    'subject_id' =>  $achievement->classsubject->subject->subjectname,
                    'class_sub' => $achievement->classSubject_id
//                    'type' => $subject->type,
                ];
            }),
//            'links' => [
//                'self' => 'link-value',
//            ],
        ];
    }
}
