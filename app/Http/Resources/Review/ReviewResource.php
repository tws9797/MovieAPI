<?php

namespace App\Http\Resources\Review;

use Illuminate\Http\Resources\Json\Resource;

class ReviewResource extends Resource
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
          'id' =>  $this->when(!is_null($this->id), $this->id),
          'username' => $this->whenLoaded('user')->name,
          'review' => $this->when(!is_null($this->review), $this->review),
          'star' => $this->when(!is_null($this->star), $this->star)
        ];
    }
}
