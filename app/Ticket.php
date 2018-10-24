<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public function category()
    {
      return $this->belongsTo('App\Category');
    }

    public function location()
    {
      return $this->belongsTo('App\Location');
    }
    public function user()
    {
        return $this->belongsToMany('App\User', 'tickets_assignee', 'ticket_id', 'user_id');
    }
    public function status()
    {
      return $this->belongsTo('App\Status');
    }
}
