<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Location extends Model
{
  use SoftDeletes;
  public function ticket()
  {
    return $this->hasMany('App\Ticket');
  }
  public function group()
  {
    return $this->belongsTo('App\Group');
  }
  public static function boot()
  {
    parent::boot();

    static::addGlobalScope(new Scopes\LocationScope);
  }
}
