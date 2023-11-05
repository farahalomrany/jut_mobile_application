<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class IsNotGuest extends BaseController

{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth()->user()->userable_type == 'distributor' ||Auth()->user()->userable_type == 'member' 
            ||Auth()->user()->userable_type == 'admin' ||Auth()->user()->userable_type == 'observer')
             
        {
            return $next($request);
        }
      
        return $this->sendError([],'You are still a Guest,sorry!');
            // return $this->sendError([],'Your must be distributor,observer or member');
       
        
    }
}
