<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TestResource extends JsonResource
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
            'testname' => $this->testname,
            'average' => $this->average,
            'percentage' => $this->percentage,
            'date' => Carbon::createFromFormat('Y-m-d H:i:s',$this->updated_at)->toDateString()
        ];
    }
}
