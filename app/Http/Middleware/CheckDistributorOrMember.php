<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Distributor;
use App\Models\User;
use App\Models\Member;
use App\Http\Controllers\BaseController;

class CheckDistributorOrMember extends BaseController
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
        
        if (Auth()->user()->userable_type == 'distributor' || Auth()->user()->userable_type == 'member'){
            return $next($request);
        }
        return $this->sendError([],'Your must be distributor or member');
        
    }
}
