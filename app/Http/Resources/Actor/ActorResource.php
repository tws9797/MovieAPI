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
          'id' => $this->when(!is_null($this->id), $this->id),
          'name' => $this->when(!is_null($this->name), mb_strtoupper($this->name)),
          'movies' => $this->whenLoaded('movies')->pluck('name')
        ];
    }
}
