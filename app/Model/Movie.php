<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{

    protected $fillable = [
      'name',
      'plot',
      'year',
      'director_id',
    ];

    public function director(){
      return $this->belongsTo(Director::class);
    }

    public function actors(){
      return $this->belongsToMany(Actor::class);
    }

    public function reviews(){
      return $this->hasMany(Review::class);
    }
}
