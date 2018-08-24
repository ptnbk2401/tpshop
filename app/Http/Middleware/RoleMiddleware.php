<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next, $role)
    {
        $username = Auth::user()->username;
        if(strpos($role,$username)===false ){
            $request->session()->flash('msg-error','Bạn không có quyền thực hiện Thao tác!');
            return redirect()->back();
        }
        return $next($request);
   }
}
