<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class TotalCount
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
        $url=$_SERVER['REQUEST_URI'];
        $url2=strpos($url,'?');
        if($url2){
            $url=substr($url,0,$url2);
        }
        Redis::zincrby('tcount',1,$url);
        return $next($request);
    }
}
