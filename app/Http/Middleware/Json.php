<?php

namespace App\Http\Middleware;

use Closure;

class Json
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$request->isJson()){
            return response()->json(['error' => 'Response is not JSON type.']);
        }
        return $next($request);
    }

}