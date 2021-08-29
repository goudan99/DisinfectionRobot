<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Factory as Auth;
use App\Constant\Code;

class Permit
{
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;
		
		$isPermit=true;
		
        foreach ($guards as $guard) {
			
            $user= $this->auth->guard($guard)->user();
			
			$isPermit=$isPermit&&$user->check($request->route()->uri(),$request->route()->methods());
        }
		
		if(!$isPermit){
			return Response([
			  'code' => Code::AUTH,
			  'msg' => '你没有权限',
			  'data' => [],
			  'timestamp' => time()
			]);
		}
		
        return $next($request);
    }
}
