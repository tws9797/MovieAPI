<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{

    protected $fillable = [
      'review',
      'star'
    ];
    
    public function movie(){
      return $this->hasMany(Review::class);
    }
}
