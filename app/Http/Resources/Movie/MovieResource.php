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
          'name' => $this->name,
          'plot' => $this->plot,
          'category' => $this->category,
          'year' => $this->year,
          'rating' => $this->reviews->count() > 0 ? round($this->reviews->sum('star')/$this->reviews->count(), 2) : 'No rating yet',
          'href' => [
            'reviews' => route('reviews.index', $this->id)
          ]
        ];
    }
}
