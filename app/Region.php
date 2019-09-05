<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
  //use SoftDeletes;
  public function group()
  {
    return $this->hasMany('App\Group');
  }
}
