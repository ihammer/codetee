<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/24 0024
 * Time: 16:25
 */

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Extend\Wechat;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class WechatController extends Controller
{
    public function WechatUrl(){
        $url=(new Wechat())->get_authorize_url();
        header("Location:".$url);
    }
    public function WechatCallback(Request $request){
         $code=$request['code'];
         $wechat=new  Wechat();
         //获取token
        $token_data=$wechat->get_access_token($code);
        $token=$token_data['access_token'];
        $openid=$token_data['openid'];
        //后去用户信息
        $info=$wechat->get_user_info($token,$openid);
        //判断是否注册
        $userInfo=User::where([['uuid','=',$info['unionid']]])->first();
        if(!$userInfo){
            //添加用户信息
            $inData['name']=$info['nickname'];
            $inData['uuid']=$info['unionid'];
            $inData['password']=bcrypt('mt123789');
            $inData['auth_pwd']=Crypt::encrypt('mt123789');
            $inData['avatar']=$info['headimgurl'];
            $inData['sex']=$info['sex'];
            $inData['app_flag']=1;
            $user_id=User::insertGetid($inData);
        }
        $userInfo=User::where([['uuid','=',$info['unionid']]])->first();
        //登录操作
        $user['uuid']=$userInfo['uuid'];
        $user['password']=Crypt::decrypt($userInfo['auth_pwd']);
        if(true==\Auth::guard('webuser')->attempt($user)){
            $data['login_time']=date('Y-m-d H:i:s',time());
            User::where([['id','=',$userInfo['id']]])->update($data);
            return back(2);
        }
        return $this->Interface_error('登录失败');
    }
}