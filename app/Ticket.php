<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;
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
    public function created_by_user()
    {
      return $this->belongsTo('App\User','created_by');
    }
    public function requested_by_user()
    {
      return $this->belongsTo('App\User','requested_by');
    }
}
