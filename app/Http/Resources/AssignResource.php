<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AssignResource extends JsonResource
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
            'subject' => new SubjectResource($this->subject),
            'teacher' => new UserResource($this->teacher),
            'class' => new ClassResource($this->lophoc),
//                    'type' => $subject->type,
        ];
    }
}
