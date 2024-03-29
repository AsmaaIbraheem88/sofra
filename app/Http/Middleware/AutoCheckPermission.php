<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Permission;

class AutoCheckPermission
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

        $routeName = $request->route()->getName();// user.index 
        
        $permission = Permission::whereRaw("FIND_IN_SET('$routeName',routes)")->first();
      
        if($permission)
        {
            if(!admin()->user()->can($permission->name))
            {
                abort(403);
            }
        }
        return $next($request);
    }
}
