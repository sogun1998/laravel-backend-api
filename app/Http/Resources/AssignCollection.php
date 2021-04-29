<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AssignCollection extends ResourceCollection
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
            'data' => $this->collection->map(function ($assign){
                return [
                    'id' => $assign->id,
                    'subject' => new SubjectResource($assign->subject),
                    'teacher' => new UserResource($assign->teacher),
                    'class' => new ClassResource($assign->lophoc),
//                    'type' => $subject->type,
                ];
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
