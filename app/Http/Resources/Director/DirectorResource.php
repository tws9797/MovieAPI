<?php

namespace App\Http\Resources\Director;

use Illuminate\Http\Resources\Json\Resource;

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
          'name' => $this->name,
        ];
    }
}
