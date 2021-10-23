<?php

namespace App\Http\Middleware;

use Closure;
use Log;
use Illuminate\Http\Request;

class TestRequire
{

    public function handle(Request $request, Closure $next, ...$guards)
    {
        Log::info("header:",$request->headers->all());
		Log::info("data:",$request->all());
        return $next($request);
    }
}
