<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/24 0024
 * Time: 15:40
 * 微信授权相关接口
 */
namespace App\Http\Controllers\Extend;
class Wechat{

    //
    private $app_id = 'wx17635e34de70d631';
    private $app_secret = '3f9ef4045a04cb7c1ba61785ebb3fb94';
    private $redirect_uri ='http://codetee.pillele.cn/auth/weixin/callback';


    /**
     * 获取微信授权链接
     *
     * @param string $redirect_uri 跳转地址
     * @param mixed $state 参数
     * @return string
     */
    public function get_authorize_url()
    {
        $state =uniqid().time();
        $redirect_uri = urlencode($this->redirect_uri);
        $url="https://open.weixin.qq.com/connect/qrconnect?appid={$this->app_id}&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_login&state={$state}#wechat_redirect";
        return $url;
    }

    /**
     * 获取授权token
     *
     * @param string $code 通过get_authorize_url获取到的code
     * @return  string
     */
    public function get_access_token( $code = '')
    {
        $token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->app_id}&secret={$this->app_secret}&code={$code}&grant_type=authorization_code";
        $token_data = $this->TCurl($token_url,false,false,'GET');
        if($token_data[0] == 200)
        {
            return json_decode($token_data[1], TRUE);
        }
        return FALSE;
    }

    /**
     * 获取授权后的微信用户信息
     *
     * @param string $access_token
     * @param string $open_id
     * @return  string
     */
    public function get_user_info($access_token = '', $open_id = '')
    {
        if($access_token && $open_id)
        {
            $info_url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$open_id}&lang=zh_CN";
            $info_data = $this->TCurl($info_url,false,false,'GET');
            if($info_data[0] == 200)
            {
                return json_decode($info_data[1], TRUE);
            }
        }
        return FALSE;
    }

    /**
     * @param $url
     * @param $data
     * @param bool $header
     * @param string $method
     * @return mixed
     * @name Curl
     * @author wudean
     */
    public function TCurl($url, $data, $header = false, $method = "POST")
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ($header) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return array($http_code, $response);
    }
}