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
      $userGroup = Auth::user()->group->first()->id;
      if (Auth::user()->hasRole('admin')) {
        $builder;
      }
      elseif (Auth::user()->hasPermissionTo('view group tickets')) {

     $builder->where('group_id', $userGroup);
   } else {
     $userId = Auth::user()->id;
    $builder->whereHas('user', function ($q) use ($userId) {
    $q->where('user_id', $userId);})->where('group_id', $userGroup);
   }
  }
}
