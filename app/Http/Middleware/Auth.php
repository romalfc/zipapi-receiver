<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class Auth
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
        $user_id = User::authorization($request);
        if(!$user_id){
            return response()->json(['error' => 'Authorization failed!']);
        }
        $request->merge(['user_id' => $user_id]);
        return $next($request);
    }

}