<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Laravel\Scout\Searchable;
use Auth;
use App\Scopes\GlobalScope;
use App\Scopes\LocationScope;
use App\Scopes\CategoryScope;

class Ticket extends Model
{
    use SoftDeletes, LogsActivity, Searchable;

    protected static $logAttributes = ['*'];

    protected static $logOnlyDirty = true;

     public $asYouType = true;

    public function category()
    {
      return $this->belongsTo('App\Category')->withoutGlobalScope(CategoryScope::class);
    }
    public function group()
    {
      return $this->belongsTo('App\Group');
    }
    public function location()
    {
      return $this->belongsTo('App\Location')->withoutGlobalScope(LocationScope::class);
    }
    public function user()
    {
        return $this->belongsToMany('App\User', 'tickets_assignee', 'ticket_id', 'user_id')->withTimestamps();
    }
    public function status()
    {
      return $this->belongsTo('App\Status');
    }
    public function rating()
    {
      return $this->hasOne('App\Rating','ticket_id','id');
    }
    public function created_by_user()
    {
      return $this->belongsTo('App\User','created_by');
    }
    public function requested_by_user()
    {
      return $this->belongsTo('App\User','requested_by');
    }
    public function activites()
    {
        return $this->morphOne('App\Activity', 'imageable');
    }
    public function comments()
    {
    return $this->morphMany('App\Comment', 'commentable')->whereNull('parent_id');
    }
    public function toSearchableArray()
    {
    $array = $this->toArray();

    $array['status_id'] = $this->status->status_name;
    $array['location_id'] = $this->location->location_name;
    $array['category_id'] = $this->category->category_name;
    $array['group_id'] = $this->group->group_name;
    $array['ticket_id'] = $this->id;

    // $user = $this->user()->get(['name'])->map( function ($user) {
    //              return $user['name'];
    //     });
    //     $array['user'] = implode(' ', $user->toArray());

    return $array;
    }

    public static function boot()
    {
      parent::boot();

      static::addGlobalScope(new Scopes\GlobalScope);
    }

    public function scopeLocalTicket($query) {
      $userGroups = Auth::user()->group;
      foreach ($userGroups as $userGroup) {
        $userGroupIDs[] =  $userGroup->id;
      };
      $userTickets = Auth::user()->ticket;
      if ($userTickets){


      $userTicketIDs = [];
      foreach ($userTickets as $userTicket) {
        $userTicketIDs[] =  $userTicket->id;
      };
      if (Auth::user()->hasRole('admin')) {
        return $query;
      }
      elseif (Auth::user()->hasPermissionTo('view group tickets')) {
        $query->whereIn('group_id', $userGroupIDs)->orWhere('requested_by', Auth::user()->id)->orWhere('created_by', Auth::user()->id);
      }
      elseif (Auth::user()->hasPermissionTo('change ticket status')) {
        $userId = Auth::user()->id;
        $query->whereIn('id', $userTicketIDs)
        ->orWhere('created_by', Auth::user()->id)->orWhere('requested_by', Auth::user()->id);

      }
      else{
            $query->where('requested_by', Auth::user()->id)->orWhere('created_by', Auth::user()->id);
      }
    }
   }
   public function scopeRequestedCreatedBy($query) {
          $query->where('requested_by', Auth::user()->id)->orWhere('created_by', Auth::user()->id);
 }
 public function scopeHisGroup($query) {
  $userGroups = Auth::user()->group;
  foreach ($userGroups as $userGroup) {
    $userGroupIDs[] =  $userGroup->id;
  };
  $query->whereIn('group_id', $userGroupIDs);
}
}
