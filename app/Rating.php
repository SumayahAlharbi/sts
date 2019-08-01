<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Rating extends Model
{
  public function ticket()
  {
    return $this->belongsTo('App\ticket','ticket_id');
  }
}
