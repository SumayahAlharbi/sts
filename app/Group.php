<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Glorand\Model\Settings\Traits\HasSettingsTable;

class Group extends Model
{
  use SoftDeletes,
    HasSettingsTable;

  public $defaultSettings = [
    'email_assigned_agent' => true,
    'email_ticket_departmental' => true,
    'email_ticket_confirmation' => true,
    'email_ticket_rating' => true,
    'allow_enduser_ticket' => true,
  ];

  public function user()
  {
    return $this->belongsToMany('App\User', 'group_user', 'group_id', 'user_id');
  }
  public function ticket()
  {
    return $this->hasMany('App\Ticket');
  }
  public function location()
  {
    return $this->hasMany('App\Location');
  }
  public function category()
  {
    return $this->hasMany('App\Category');
  }
  public function region()
  {
    return $this->belongsTo('App\Region');
  }
}
