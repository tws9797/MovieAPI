<?php

namespace App\Http\Resources\Movie;

use Illuminate\Http\Resources\Json\Resource;

class MovieResource extends Resource
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
          'director' => $this->when(!$this->whenLoaded('director')->empty(),
            new DirectorResource($this->director)),
          'actor' => $this->when(!$this->whenLoaded('actors')->empty(),
            ActorResource::collection($this->actors)),
          'plot' => $this->when(!is_null($this->plot), $this->plot),
          'category' => $this->when(!is_null($this->category), $this->category),
          'year' => $this->when(!is_null($this->year), $this->year),
          'rating' => $this->reviews->count() > 0 ? round($this->reviews->sum('star')/$this->reviews->count(), 2) : 'No rating yet',
          'href' => [
            'reviews' => route('reviews.index', $this->id)
          ]
        ];
    }
}
