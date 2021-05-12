<?php

namespace App\Http\Resources;

use App\LevelTeacher;
use App\User;
use Illuminate\Http\Resources\Json\ResourceCollection;

class LevelTeacherCollection extends ResourceCollection
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
            'data' => $this->collection->map(function ($level){
                return [
                    'id' => $level->id,
                    'level' => $level->level,

                    'subject' => $level->subject,
//            'grade' =>  $this->grade,
                    'canBeKeyTeacher' =>  $level->canBeKeyTeacher,
//            'teacher' =>  $this->teacher,
//                    'create_by' => $level->admin,
                    'teacher' => new TeacherStatusResource(LevelTeacher::find($level->id)->teachers[0]),
//                    'level' => $student->level
//                    'form_class' => User::find(LevelTeacher::find($level->id)->teachers[0]->id)->class
                ];
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
