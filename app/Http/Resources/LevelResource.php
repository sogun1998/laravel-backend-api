<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LevelResource extends JsonResource
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
            'level' => $this->level,
            'subject' => $this->subject,
//            'grade' =>  $this->grade,
            'canBeKeyTeacher' =>  $this->canBeKeyTeacher,
//            'teacher' =>  $this->teacher,
            'create_by' => $this->admin
        ];

    }
}
