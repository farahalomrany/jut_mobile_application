<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Http\Controllers\BaseController;

class JointMember extends BaseController
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
        if (Auth()->user()->userable_type == 'member') {
            $member = Member::where('id',Auth()->user()->userable_id)->where('classification','!=' ,"")->first();
            if(!$member ){
                return $this->sendError([],'You are not joint member');
            }
            return $next($request);
        }
        return $this->sendError([],'You are not  member');
       
    }
}
