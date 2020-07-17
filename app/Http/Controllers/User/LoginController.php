<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\User;
use App\Model\Token;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    //登录
    public function logindo(Request $request)
    {
        $name=$request->post('name');
        $pwd=$request->post('pwd');
        //判断用户是否存在
        $res=User::where(["name"=>$name])->first();

        if($res){
            //判断密码
            $pwd=password_verify($pwd,$res->pwd);
            //token
            $token=str::random(32);
            $data=[
                'token'=>$token,
                'time'=>time()
            ];
            Token::create($data);

            if($pwd){
                $response=[
                    "error"=>0,
                    "msg"=>"Ok",
                    "token"=>$token
                ];
            }else{
                $response=[
                    "error"=>50001,
                    "msg"=>"密码错误"
                ];
            }
        }else{
            $response=[
                "error"=>40001,
                "msg"=>"用户不存在"
            ];
        }

        return $response;
    }

    public function userCenter(Request $request){

    }

}
