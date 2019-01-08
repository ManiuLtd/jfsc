<?php
namespace App\Http\Middleware;
use Closure;
class LoginAuth{
    public function handle($request,Closure $next){
        if(session('status')==1){
            return $next($request);
        }else{
            return redirect('newLogin');
        }
    }
}
