<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
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
                    'name' => $user->name,
                    'fullname' => $user->fullname,
                    'phone' => $user->phone,
                    'email' =>  $user->email,
                    'gender' =>  $user->gender,
                    'school' => $user->school,
//            'created_at' => (string) $this->created_at,
                    'level' => $user->level
                ];
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
