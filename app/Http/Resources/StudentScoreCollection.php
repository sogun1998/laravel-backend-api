<?php

namespace App\Http\Resources;

use App\Achievement;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StudentScoreCollection extends ResourceCollection
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
            'data' => $this->collection->map(function ($student,$key){
                return [
                    'id' => $student->id,
                    'name' => $student->name,
                    'fullname' => $student->fullname,
                    'phone' => $student->phone,
                    'email' =>  $student->email,
                    'gender' =>  $student->gender,
                    'school'=>$student->school,
                    'conduct' => 0,
//                    'ids' => $student->classObj,
//                    'achievement' => new AchievementCollection($student->achievement)
                    'achievement' => new AchievementCollection(Achievement::where('classSubject_id',$student->classObj)->where('student_id',$student->id)->get())


                ];
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
