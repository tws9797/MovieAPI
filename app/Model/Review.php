<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{

    protected $fillable = [
      'user_id',
      'movie_id',
      'review',
      'star'
    ];

    public function movie(){
      return $this->belongsTo(Movie::class);
    }

    public function user(){
      return $this->belongsTo(\App\User::class);
    }
}
