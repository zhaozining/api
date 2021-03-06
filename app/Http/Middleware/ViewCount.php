<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class ViewCount
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

        //黑名单
        $blank="blank";
       $count=Redis::incr($blank,1);
        if($count>30){
            $response=[
                'error'=>50004,
                'msg'=>"访问次数超过3十次，请从新登录"
            ];
            Redis::sadd($blank,$token);
            return response()->json($response);
        }




        return $next($request);
    }
}
