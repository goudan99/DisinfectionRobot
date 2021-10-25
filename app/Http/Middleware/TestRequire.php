<?php

namespace App\Http\Middleware;

use Closure;
use Log;
use Illuminate\Http\Request;

class TestRequire
{
    protected $header = 'authorization';

    /**
     * The header prefix.
     *
     * @var string
     */
    protected $prefix = 'bearer';
	
    public function handle(Request $request, Closure $next, ...$guards)
    {
		Log::info($request->fullUrl());
        Log::info("header:",$request->headers->all());
		//Log::info("authorization:",$this->parse($request));
		Log::info("data:",$request->all());
        return $next($request);
    }
	
    /**
     * Attempt to parse the token from some other possible headers.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return null|string
     */
    protected function fromAltHeaders(Request $request)
    {
        return $request->server->get('HTTP_AUTHORIZATION') ?: $request->server->get('REDIRECT_HTTP_AUTHORIZATION');
    }

    /**
     * Try to parse the token from the request header.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return null|string
     */
    public function parse(Request $request)
    {
        $header = $request->headers->get($this->header) ?: $this->fromAltHeaders($request);

        if ($header && preg_match('/'.$this->prefix.'\s*(\S+)\b/i', $header, $matches)) {
            return $matches[1];
        }
    }
}
