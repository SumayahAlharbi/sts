<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function ticket()
    {
        return $this->belongsToMany('App\Ticket','tickets_assignee');
    }
    public function group()
    {
        return $this->belongsToMany('App\Group','group_user', 'user_id', 'group_id');
    }
    public function getGravatarAttribute()
    {
      $hash = md5(strtolower(trim($this->attributes['email'])));
      return "https://www.gravatar.com/avatar/$hash";
    }
}
