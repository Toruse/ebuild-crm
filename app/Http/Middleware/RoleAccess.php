<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleAccess
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
        $roles = array_slice(func_get_args(), 2);

        foreach ($roles as $role) {
            try {
                if (method_exists(Auth::user(), $role) && Auth::user()->$role()) {
                    return $next($request);
                }
            } catch (Exception $exception) {
                return redirect('login');    
            }
        }
        
        return redirect('login');
    }
}
