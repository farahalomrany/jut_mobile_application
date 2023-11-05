<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Admin;

class CheckGuest extends BaseController
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
        if (Auth()->user()->userable_type !== 'App\Models\Distributor' ||Auth()->user()->userable_type !== 'App\Models\Member' 
            ||Auth()->user()->userable_type !== 'App\Models\Admin' ||Auth()->user()->userable_type !== 'App\Models\Observer')
             
        {
            return $next($request);
        }
      
        return $this->sendError([],'You are still a Guest,sorry!');
      
      
    }
}
