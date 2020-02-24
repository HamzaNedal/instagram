<?php

namespace App\Http\Middleware;

use Closure;
use Admins;
use Illuminate\Support\Facades\Hash;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$guard = null)
    {

      if (!auth()->guard("admin")->check()) {

          return redirect('admin/login');

        }
        return $next($request);


        
    }
}
