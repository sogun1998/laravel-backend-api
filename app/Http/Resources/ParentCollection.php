<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ParentCollection extends ResourceCollection
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
            'data' => $this->collection->map(function ($student){
                return [
                    'id' => $student->id,
                    'name' => $student->name,
                    'fullname' => $student->fullname,

                    'parent' => $student->parent,
                    'class' =>  new ClassResource($student->class),
//                    'gender' =>  $student->gender,
//                    'school'=>$student->school
//            'created_at' => (string) $this->created_at,
//                    'level' => $student->level
                ];
            }),
        ];
    }
}
