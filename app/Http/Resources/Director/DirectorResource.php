<?php

namespace App\Http\Resources\Director;

use Illuminate\Http\Resources\Json\Resource;
use App\Http\Resources\Movie\MovieResource;

class DirectorResource extends Resource
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
          'name' => $this->when(!is_null($this->name), $this->name),
          'movie' => $this->when(!$this->whenLoaded('movie')->empty(),
            MovieResource::collection($this->movies))
        ];
    }
}
