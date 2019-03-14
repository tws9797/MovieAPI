<?php

namespace App\Http\Resources\Director;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DirectorCollection extends ResourceCollection
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
        'data' => DirectorResource::collection($this->collection),
        'meta' => [
          'time' => date('U'),
        ],
      ];
    }
}
