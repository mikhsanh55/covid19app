<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use Closure;
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */

    //this method will be triggered before your controller constructor
    public function handle($request, Closure $next)
    {
        //check here if the user is authenticated
        if ( ! $this->auth->user() )
        {
            // here you should redirect to login 
            return redirect('/login');
        }

        if(!Session::has('user')) {
            Session::put('user', Auth::User());
        }
        return $next($request);
    }
}
