<?php

namespace App\Http\Controllers\Ce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redis;


class TeasController extends Controller
{
    //获取token1
    public function token(){
        $appid="wxf4d9c5b635f41270";
        $appsecret="f85271c0ca76f71cdcfe5e2a96f3c29b";
        $access_token="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
        $content=file_get_contents($access_token);
        echo $content;
    }
    //获取token2
    public function token1(){

        $appid="wxf4d9c5b635f41270";
        $appsecret="f85271c0ca76f71cdcfe5e2a96f3c29b";
        $access_token="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;

        $ch = curl_init();// 创建一个新cURL资源
        // 设置URL和相应的选项
        curl_setopt($ch, CURLOPT_URL, $access_token);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $content=curl_exec($ch);// 抓取URL并把它传递给浏览器
        curl_close($ch);// 关闭cURL资源，并且释放系统资源

        echo $content;
    }
    //获取token3
    public function token2(){
        $appid="wxf4d9c5b635f41270";
        $appsecret="f85271c0ca76f71cdcfe5e2a96f3c29b";
        $access_token="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
        $client = new Client();
        $reposne=$client->request('get',"$access_token");
        $content=$reposne->getBody();
        echo $content;
    }

    //www和api互通
    public function www(){
        $url="http://www.1911.com/teas3";
        $reposen=file_get_contents($url);
        echo $reposen;
    }

    //哈希
    public function hash(){
        $data=[
            'name'=>'ning',
            'sex'=>"男",
        ];
        $ji="my";
        Redis::hmset($ji,$data);

    }
    public function hash2(){

    $ji="my";
    $jis=Redis::hmget($ji,'name','sex');
    return $jis;
    }

    //添加库存
//    public function num(){
//        $array=[
//            "me"=>"我",
//            "like"=>"喜欢",
//            "free"=>"自由"
//        ];
//        $data="I";
//        Redis::hmset($data,$array);
//    }

}
