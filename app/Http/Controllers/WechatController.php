<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WechatController extends Controller
{
    /** 获取用户列表  接口 */
    public function get_user_list()
    {
        //获取access_token
        $access_token = '';
        $token = file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRET')."");
        //dd($token);
        $access_result = json_decode($token,1);
        //dd($access_result);
        $access_token = $access_result['access_token'];
        $expire_time = $access_result['expires_in'];
        //dd($expire_time);
        // 拉去关注用户列表
        file_get_contents("https://api.weixin.qq.com/cgi-bin/user/get?access_token={$access_token}&next_openid=");
        //dd($o);
    }

    /***  token 接口*/
    public function get_access_token()
    {
        //获取access_token
        $redis = new \Redis();
        $redis->connect('127.0.0.1','6379');
        $access_token_key = 'wechat_access_token';
        if($redis->exists($access_token_key)){
            // 去缓存拿
            $access_token = $redis->get($access_token_key);
        }else{
            // 去微信借口拿
            $token = file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRET')."");
            $access_result = json_decode($token,1);
            $access_token = $access_result['access_token'];
            $expire_time = $access_result['expires_in'];
            // 加入缓存
            $redis->set($access_token_key,$access_token,$expire_time);
        }
        return $access_token;
    }

    /** 基本信息  接口 */
    public function get_user_info()
    {
        $access_token = $this->get_access_token();
        $openid = 'o3lI6xNbtIX0PnjfD1U0j933HBqA';
        $wechat_user = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid={$openid}&lang=zh_CN");
        $user_info = json_decode($wechat_user,1);
        dd($user_info);
    }
}
