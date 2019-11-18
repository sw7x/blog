<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuthCheck
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
        //dd($request->path());


//--- login->
        //$pageArr = ['admin','admin/logout',];

        if($request->path() == 'admin'){
            return $next($request);
        }else{
            if(!Auth::check()){
                //return redirect ('/s')
                return redirect()->route('admin.index');
            }else{
                return $next($request);
            }
        }

    }
}
