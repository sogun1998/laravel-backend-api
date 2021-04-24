<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ClassCollection extends ResourceCollection
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
            'data' => $this->collection->map(function ($class){
                return [
                    'id' => $class->id,
                    'classname' => $class->classname,
                    'grade' => $class->grade,
                    'teacher_name' => $class->teacher->fullname,
                    'school' =>  $class->school,
                    'num_student'=> count($class->students)
//                    'gender' =>  $student->gender,
//                    'school'=>$student->school
//            'created_at' => (string) $this->created_at,
//                    'level' => $student->level
                ];
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
