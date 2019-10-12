<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth()->user()->isAdministrator()) {
            return $next($request);
        }

        return redirect('home')->with('error', trans('You did not have permission to access the page. You have been redirected to the home page.'));
    }
}
