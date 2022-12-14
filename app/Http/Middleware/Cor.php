<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
           return $next($request)
               ->header('Access-Control-Allow-Origin', 'http://127.0.0.1:5173/')
               ->header('Access-Control-Allow-Methods', '*')
               ->header('Access-Control-Allow-Credentials', 'true')
               ->header('Access-Control-Allow-Headers', 'X-CSRF-Token');
    }
   
}
