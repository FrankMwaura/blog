<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTAuthentication
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
        $user = JWTAuth::parseToken()->authenticate();
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof TokenExpiredException) {
                $newToken = JWTAuth::parseToken()->refresh();
                return response()->json(['success'=>false, 'token'=>$newToken, 'status'=>'Token Expired'], 200);
            }else if($e instanceof TokenInvalidException){
                return response()->json(['success'=>false, 'message'=>'Token Invalid'], 401);
            }else{
                return response()->json(['success'=>false, 'message'=>'Token Not Found'], 401);
            }
        }
        return $next($request);
    }
}
