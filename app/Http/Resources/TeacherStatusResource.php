<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherStatusResource extends JsonResource
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
            'fullname' =>  $this->fullname,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' =>  $this->email,
            'gender' =>  $this->gender,
//            'fullname' =>  $this->fullname,
//            'created_at' => (string) $this->created_at,
//            'level' => $this->level,
            'school' => $this->school,
//            'level' => new LevelResource($this->level)
            'form_class' => $this->class,
            'teach_class' => $this->classsubject
        ];
    }
}
