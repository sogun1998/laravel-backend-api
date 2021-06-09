<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ParentResource extends JsonResource
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
            'fullname' => $this->fullname,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' =>  $this->email,
            'gender' =>  $this->gender,
            'student' => new StudentResource($this->student),
            'update_at' => (string) $this->updated_at,
//            'class_id'=> $this->lophoc_id,
//            'conductSummary' => new ConductSummaryCollection($this->conductSummary),
//            'class' => new ClassResource($this->class)
//            'level' => $this->level
        ];
    }
}
