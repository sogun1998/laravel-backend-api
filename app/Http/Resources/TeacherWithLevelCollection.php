<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TeacherWithLevelCollection extends ResourceCollection
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
            'data' => $this->collection->map(function ($user){
                return [
                    'id' => $user->id,
                    'fullname' => $user->fullname,

//            'created_at' => (string) $this->created_at,
//                    'level' => new LevelResource($user->level)
                ];
            }),
        ];
    }
}
