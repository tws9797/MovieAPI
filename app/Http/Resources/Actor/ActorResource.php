<?php

namespace App\Http\Resources\Actor;

use Illuminate\Http\Resources\Json\Resource;

class ActorResource extends Resource
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
        'name' => $this->name,
      ];
    }
}
