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
        $sum  = 0;
        $count = 0;
        return [
            'data' => $this->collection->map(function ($achievement){
//                if($achievement->conduct->count() > 0){
//                    $sum
//                }
                return [
                    'id' => $achievement->id,
                    'mark' => new MarkResource($achievement->mark),
                    'subject_id' =>  $achievement->classsubject->subject->subjectname,
                    'class_sub' => $achievement->classSubject_id,
//                    'conduct' => new ConductCollection($achievement->conduct),
//                    'type' => $subject->type,
                    'avg' => $achievement->conduct->avg('mark')
                ];
            }),
//            'links' => [
//                'self' => 'link-value',
//            ],
        ];
    }
}
