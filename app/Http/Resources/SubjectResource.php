<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
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
//          'id'=> $this->id,

            'id' => $this->id,
            'subjectname' => $this->subjectname,
            'type' => $this->type,
            'grade' => $this->grade,
//            'email' =>  $this->email,
//            'gender' =>  $this->gender,
            'school' => $this->school,
//            'update_at' => (string) $this->updated_at,
//            'level' => $this->level
        ];
    }
}
