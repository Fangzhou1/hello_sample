<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

class CheckPermission
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

     //dd(Route::currentRouteName());
      $route=Route::currentRouteName();
      $permission=Permission::where('route',$route)->first();
      //dd($route);
      if(Auth::user()->can($permission->name))

           return $next($request);

        else{
          session()->flash('warning', '您没有权限进入，请联系管理员！');
          return redirect('/');
        }


    }
}
