<?php

namespace App\Http\Resources\Actor;

use Illuminate\Http\Resources\Json\Resource;
use App\Http\Resources\Movie\MovieResource;

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
        'id' => $this->id,
        'name' => $this->name,
        'movies' => MovieResource::collection($this->movies),
      ];
    }
}
