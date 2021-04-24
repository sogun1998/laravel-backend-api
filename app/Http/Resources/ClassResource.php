<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClassResource extends JsonResource
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
            'classname' => $this->classname,
            'grade' => $this->grade,
//            'grade' =>  $this->grade,
            'school' =>  $this->school,
//            'teacher' =>  $this->teacher,
            'key_teacher' => $this->teacher,
            'num_student'=> count($this->students)
        ];
    }
}
