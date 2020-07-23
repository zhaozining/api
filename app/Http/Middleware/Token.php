<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class Token
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
        //token
        $token = $request->get('token');
        if(empty($token)){
            $response=[
                'error'=>"50003",
                "msg"=>"未授权"
            ];
            return response()->json($response);
        }

        $tokenm='token';
        $time=Redis::hgetall($tokenm);

        $times=time()-$time['time'];
       

        if($times>7200){
            $response=[
                'error'=>50004,
                'msg'=>"授权失败"
            ];
            return response()->json($response);
        }

        return $next($request);
    }
}
