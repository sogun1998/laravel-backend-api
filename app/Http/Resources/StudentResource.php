<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'school' => $this->school,
            'update_at' => (string) $this->updated_at,
//            'level' => $this->level
        ];
    }
}
