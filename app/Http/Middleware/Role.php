<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param array $roles
     * @return mixed
     */
    public function handle($request, Closure $next, ... $roles)
    {
        if(auth()->user()->isAdministrator()) {
            return $next($request);
        }

        foreach ($roles as $role) {
            if(auth()->user()->hasRole($role)) {
                return $next($request);
            }
        }

        return redirect('home')->with('error', trans('You did not have permission to access the page. You have been redirected to the home page.'));
    }
}
