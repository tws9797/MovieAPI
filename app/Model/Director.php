<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Director extends Model
{

    protected $fillable = [
      'name'
    ];

    public function movies(){
      return $this->hasMany(Movie::class);
    }
}
