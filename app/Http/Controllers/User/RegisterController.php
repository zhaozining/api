<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\User;

class RegisterController extends Controller
{
    public function registerdo(Request $request)
    {
        $name = $request->post('name');
        $pwd = $request->post('pwd');
        $pwd2 = $request->post('pwd2');
        $email = $request->post('email');
        $phone = $request->post('phone');



        //判断唯一性
        $res = User::where(['name' => $name])->first();
        if ($res) {
            $response = [
                'error' => 40002,
                'msg' => "用户名已存在"
            ];
        }else{
            if ($pwd == $pwd2) {
                $pwd = password_hash($pwd, PASSWORD_DEFAULT);
                $content = [
                    'name' => $name,
                    'pwd' => $pwd,
                    'email' => $email,
                    'phone' => $phone
                ];
                $res2 = User::create($content);
                if ($res2) {
                    $response = [
                        'error' =>0,
                        'msg' => "OK"
                    ];
                }
            }else{
                $response = [
                    'error' => 40003,
                    'msg' => "密码不一致"
                ];
            }
        }
        return $response;
    }
}
