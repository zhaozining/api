<?php

namespace App\Http\Controllers\Ce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EncController extends Controller
{
    public function enc(){

        $data="任我是三千年的成长，人世间流浪";

        //echo $data;die;
        $method="AES-256-CBC";
        $privatekey="sing";
        $iv="qqqqwwwweeeerrrr";
        $content=openssl_encrypt($data,$method,$privatekey,OPENSSL_RAW_DATA ,$iv);
        //echo $content;
        $contents=base64_encode($content);
        echo $contents;echo "<br>";

        $www="http://www.1911.com/dec"."?data=".urlencode($contents);

        $response=file_get_contents($www);
        echo $response;

    }

    public function prienc(){
        $data="看海天一色，听风起雨落，执子手吹散苍茫茫烟波";
        $key=file_get_contents(storage_path("secretKey/priv.key"));
        $prikey=openssl_get_privatekey ($key);
       // echo $prikey;die;
        openssl_private_encrypt($data,$datas,$prikey);

        $url="http://www.1911.com/pubdec";

        $ch = curl_init();// 创建一个新cURL资源
        // 设置URL和相应的选项
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);

        $content=curl_exec($ch);// 抓取URL并把它传递给浏览器
        curl_close($ch);// 关闭cURL资源，并且释放系统资源

        //echo $content;

        //接收回复
        //$data2=file_get_contents('php://input');
        $key2=file_get_contents(storage_path("secretKey/priv.key"));
        $prikey2=openssl_get_privatekey($key2);
        // echo $prikey;die;
        openssl_private_decrypt($content,$data2s,$prikey2);
        echo $data2s;

    }

    public function signature(){
        $key="api";
        $data="蓝蓝滴天空，清清滴湖水";
        $sign=md5($key.$data);
        $url="http://www.1911.com/signature?data=".$data."&sign=".$sign;
        $content=file_get_contents($url);
        echo $content;

    }

    public function privsign(){

        $data="再烦，也别忘了微笑";
        $key="api";
        $keypriv=file_get_contents(storage_path("secretKey/priv.key"));
        $keyprivs=openssl_get_privatekey($keypriv);
        $sign=openssl_private_encrypt($key.$data,$datas,$keyprivs);
        $url="http://www.1911.com/privsign?data=".$data."&sign=".$sign;
        $content=file_get_contents($url);
        echo $content;

    }

}