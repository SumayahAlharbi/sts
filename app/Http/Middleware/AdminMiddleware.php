<?php

namespace App\Http\Middleware;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Closure;
use App\User;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->hasRole('admin')) {
          return $next($request);
        }else{
          return abort(401, 'Unauthorized action.');
        }
         return $next($request);
    }
}
