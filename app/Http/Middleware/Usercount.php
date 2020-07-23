<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;
use App\Model\Token;

class Usercount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed'
     */
    public function handle($request, Closure $next)
    {
        $tokenm='token';
        $token=Redis::hgetall($tokenm);
        $token=$token['token'];
        //dd($token);

        $url=$_SERVER['REQUEST_URI'];
        $url2=strpos($url,'?');
        if($url2){
            $url=substr($url,0,$url2);
        }
        //dd($url);

        $res=Token::where(['token'=>$token])->first();
        //dd($res['user_id']);
        $ucount="ucount".$res['user_id'];
        Redis::hincrby($ucount,$url,1);

        return $next($request);
    }
}
