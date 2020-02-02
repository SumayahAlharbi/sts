<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Auth;
use App\Group;

class GlobalScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
      if (app()->runningInConsole()) {
        return;
          }
      $userGroups = Auth::user()->group;
        foreach ($userGroups as $userGroup) {
          $userGroupIDs[] =  $userGroup->id;
        };
        // $userTickets = Auth::user()->ticket;
        // foreach ($userTickets as $userTicket) {
        //   $userTicketIDs[] =  $userTicket->id;
        // };
      if (Auth::user()->hasRole('admin')) {
        $builder;
      }
      elseif (Auth::user()->hasPermissionTo('view group tickets')) {
     $builder->whereIn('group_id', $userGroupIDs);
   } elseif (Auth::user()->hasPermissionTo('change ticket status')) {
     $userId = Auth::user()->id;
    $builder->whereHas('user', function ($q) use ($userId) {
    $q->where('user_id', $userId);})->whereIn('group_id', $userGroupIDs);
    // $builder->whereIn('id', $userTicketIDs)
    // ->orWhere('created_by', Auth::user()->id)->orWhere('requested_by', Auth::user()->id);

    //  $builder->whereHas('user', function ($query) {
    //   $userId = Auth::user()->id;
    //   $query->where('user_id', $userId);
  // });
  } else {
    $builder->where('requested_by', Auth::user()->id)->orWhere('created_by', Auth::user()->id);
  }
  }
}
