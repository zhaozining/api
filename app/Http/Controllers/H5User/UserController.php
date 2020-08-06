<?php

namespace App\Http\Controllers\H5User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\User;
use App\Model\Token;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class UserController extends Controller
{
    //注册
    public function register(){

        $name = request()->post('name');
        $email = request()->post('email');
        $pwd = request()->post('pwd');


        //判断唯一性
        $res = User::where(['name' => $name])->first();
        if ($res) {
            $response = [
                'error' => 40002,
                'msg' => "用户名已存在"
            ];
        }else{

                $pwd = password_hash($pwd, PASSWORD_DEFAULT);
                $data = [
                    'name' => $name,
                    'pwd' => $pwd,
                    'email'=>$email
                ];
                $res2 = User::create($data);
                if ($res2) {

                    $response = [
                        'error' =>0,
                        'msg' => "OK"
                    ];
                }

        }
        return $response;
    }


    //登录
    public function logindo(){
       // echo 111;die;
        $name=request()->input('name');
        $pwd=request()->input('pwd');
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
                            "token"=>$tokens->token,
                            'time'=>time()
                        ];
                        $tokenm="token";
                        Redis::hmset($tokenm,$response);
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
                            "token"=>$tokens->token,
                            'time'=>$tokens->time
                        ];
                        $tokenm="token";
                        Redis::hmset($tokenm,$response);
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
                        "token"=>$token,
                        "time"=>time()
                    ];
                    $tokenm="token";
                    Redis::hmset($tokenm,$response);

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

    //个人中心
    public function conter(){
        $token = request()->post('token');
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
