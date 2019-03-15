<?php

namespace App\Http\Resources\Movie;

use Illuminate\Http\Resources\Json\Resource;
use App\Http\Resources\Actor\ActorResource;
use App\Http\Resources\Director\DirectorResource;

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
          'plot' => $this->when(!is_null($this->plot), $this->plot),
          'category' => $this->when(!is_null($this->category), $this->category),
          'year' => $this->when(!is_null($this->year), $this->year),
          'rating' => $this->reviews->count() > 0 ? round($this->reviews->sum('star')/$this->reviews->count(), 2) : 'No rating yet',
          'director' => $this->whenLoaded('director')->name,
          'actors' => $this->whenLoaded('actors')->pluck('name'),
          'href' => [
            'reviews' => route('reviews.index', $this->id)
          ]
        ];
    }
}
