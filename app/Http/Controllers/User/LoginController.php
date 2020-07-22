<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\User;
use App\Model\Token;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    //登录
    public function logindo(Request $request)
    {
        $name=$request->input('name');
        $pwd=$request->input('pwd');
        //判断用户是否存在
        $res=User::where(["name"=>$name])->first();
       
        if($res){
            //判断密码
            $pwd=password_verify($pwd,$res->pwd);
            //token
            $tokens=Token::where(['user_id'=>$res->user_id])->first();
            if($tokens){
                $time=time()-$tokens['time'];
                if($time>7200){
                    Token::where(['user_id'=>$tokens->user_id])->update(['time'=>time()]);

                    if($pwd){
                        $response=[
                            "error"=>0,
                            "msg"=>"Ok,登录成功",
                            "token"=>$tokens->token
                        ];
                    }else{
                        $response=[
                            "error"=>50001,
                            "msg"=>"密码错误"
                        ];
                    }
                }else{
                    if($pwd){
                        $response=[
                            "error"=>0,
                            "msg"=>"Ok,登录成功",
                            "token"=>$tokens->token
                        ];
                    }else{
                        $response=[
                            "error"=>50001,
                            "msg"=>"密码错误"
                        ];
                    }
                }
            }else{
                $token=str::random(32);
                $data=[
                    'token'=>$token,
                    'time'=>time(),
                    'user_id'=>$res->user_id
                ];
                Token::create($data);

                if($pwd){
                    $response=[
                        "error"=>0,
                        "msg"=>"Ok,登录成功",
                        "token"=>$token
                    ];
                }else{
                    $response=[
                        "error"=>50001,
                        "msg"=>"密码错误"
                    ];
                }
            }

        }else{
            $response=[
                "error"=>40001,
                "msg"=>"用户不存在"
            ];
        }

        return $response;
    }


    //token进个人中心
    public function userCenter(Request $request)
    {
        $token = $request->get('token');
        if(empty($token)){
            $response=[
                'error'=>"50003",
                "msg"=>"Token不能为空"
            ];
        }

        $res = Token::where(['token' => $token])->first();
        $time=time()-$res['time'];
        //echo $time;die;
        if($time>7200){
            $response=[
                'error'=>50004,
                'msg'=>"Token已过期"
            ];
        }else{
            if ($res) {
                //获取用户信息
                $user = User::where(['user_id' => $res->user_id])->first();
                //签到
                $sign="sign_in";

                //访问量
                $count="counts";

                $response=[
                    'name'=>$user->name,
                    'error'=>0,
                    'msg'=>"个人中心",
                    'sing'=>Redis::zincrby($sign,time(),"ning"),
                    'count'=>Redis::hincrby($count,'count',1)
                ];
            }else{
                $response=[
                    'error'=>50002,
                    'msg'=>"用户信息获取失败"
                ];
            }
        }
        return $response;
    }

}
