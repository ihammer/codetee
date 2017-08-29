<?php
/**
 * Created by PhpStorm.
 * User: Wudean
 * Date: 2017/8/14 0014
 * Time: 16:32
 * Name : 关于用户信息相关处理类
 */
namespace App\Http\Controllers\Applet;
use App\Http\Controllers\Extend\WXBizDataCrypt;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Session\Session;

class UserController extends Controller{

    /**
     * @name 小程序登录处理
     * @author ihammer
     */
    public function AppletAuthUser(Request $request){
        $code=request("code");
        $encryptedData=request("encryptedData");
        $iv =request('iv');
        $utoken=request("utoken",'');
        if(!empty($utoken)&&session('utoken')){
            $result["success"]=1;
            $result['utoken']=$utoken;
            echo json_encode($result);
            exit();
        }
        /*获取session_key*/
        $s_result=$this->getSession($code);
        $WxData = new WXBizDataCrypt($s_result['appid'],$s_result['session_key']);
        /*解密用户数据*/
        $errCode = $WxData->decryptData($encryptedData, $iv, $user_data);
        $wxap_key = md5(uniqid(md5(microtime(true)),true));
        $result=array();
        if($errCode==0){
            $user_data=json_decode($user_data,true);
            $result["success"]=1;
            $result['utoken']=$wxap_key;
            $user_id =$this->wxUserAdd($user_data); // 添加用户处理
            $result["user_info"]=User::where('id',$user_id)->first();//用户信息
            $user_data['uid']=$user_id;
            session(['wx_user'=>$user_data]);//缓存数据
            echo json_encode($result);
            exit();
        }else{
            $result["success"]=-1;
            $result['errCode']=$errCode;
            $result['msg']="获取用户信息出错！";
            echo json_encode($result);
            exit();
        }
    }

    /**
     * @return string
     * @name 判断用户是否登录
     * @author ihammer
     */
    public function AppletAuthUserCheck(){
        $user_id=request('user_id');
        //当前时间-登录时间>30天
        $userInfo=User::where('id',$user_id)->first();
        $Surplustime=time()-strtotime($userInfo->login_time);
        //如果当前时间减去登录时间小于30天
        if($Surplustime<(86400*30)){
            return 1;
        }else{
            return 0;
            session(['wx_user'=>null]);
        }
    }

    public function AppletAuthUserGet(){
        dd(session('wudean'));
    }

    /**
     * @param $data
     * @return int
     * @name 添加用户信息并返回用户id
     * @author ihammer
     */
    public function wxUserAdd($data){
        //根据open_id判断是否有此用户
        $wxdata['openid']=$data['openId'];
        if($userInfo=User::where('openid',$wxdata['openid'])->first()){
            User::where('id',$userInfo->id)->update(['login_time'=>date('Y-m-d H:i:s',time())]);
            return $userInfo->id;
        }
        //添加用户
        $wxdata['name']=$data['nickName'];
        $wxdata['sex']=$data['gender'];
        $wxdata['avatar']=$data['avatarUrl'];
        $wxdata['app_flag']=1;
        $wxdata['address']=$data['country'].'-'.$data['province'].'-'.$data['city'];
        $insert_id = User::insertGetid($wxdata);
        if($insert_id){
            return  $insert_id;
        }else{
            return 0;
        }
    }

    /**
     * @return string
     * @name 微信小程序用户退出
     * @author ihammer
     */
    public function wxUserLogout(){
        session(['wx_user'=>null]);
        return $this->Interface_success('已经退出');
    }

    /**
     * @param $code
     * @return bool|mixed|string
     * @name 换取 session_key
     * @author ihammer
     */
    public function getSession($code) {
        $s_data['appid'] = 'wxc22f4ae12eb4bfe1';
        $s_data['secret'] = '88a5a119b65167d44dcf01bfca68e816';
        $s_data['js_code'] = $code;
        $s_data['grant_type']="authorization_code";
        $session_url = 'https://api.weixin.qq.com/sns/jscode2session?' . http_build_query ( $s_data );
        $content = file_get_contents ( $session_url );
        $content = json_decode ( $content, true );
        $content['appid']=$s_data['appid'];
        return $content;
    }
    /**
     * @param $user_id
     * @name  根据用户id获取用的地址列表
     * @author ihammer
     * @return string
     */
    public function getUserAddress($user_id){
        $list=User::getAddressById($user_id);
        return $this->Interface_success('成功',$list);
    }

    /**
     * @param $user_id
     * @return string
     * @name 添加收货信息
     * @author ihammer
     */
    public function addUserAddress($user_id){
         //采集数据
        //consignee: 收货人信息   mobile: 手机号  province: 省份  city: 城市 county: 区县 detaile:详细地址 is_default: 是否默认地址  默认值是0
        $data['user_id']=$user_id;
        $data['consignee']=request('consignee');//收货人信息
        $data['mobile']=request('mobile');//手机号
        $data['province']=request('province');//省份
        $data['city']=request('city');//城市
        $data['county']=request('county');//区县
        $data['detaile']=request('detaile');//详细地址
        $data['is_default']=request('is_default',0);//是否默认
        //验证不能为空
        foreach ($data as $key=>$val){if(empty($val)&&$key!='is_default'){return $this->Interface_error('参数错误！');}}
        //验证手机号
        if(!$this->checkMobile($data['mobile'])){
            return $this->Interface_error('手机号错误');
        }
        //创建数据
        $id=User::Address($data);
        //更新默认数据
        if($data['is_default']==1){
            $old_info['is_default']=0;
            User::updateAddress([['user_id','=',$user_id],['id','!=',$id]],$old_info);
        }
        return $this->Interface_success('添加成功',['add_id'=>$id]);
    }

    /**
     * @param Request $request
     * @return string
     * @name  收货地址默认信息操作
     * @author ihammer
     */
    public function SetUserAddressDefault(Request $request){
        $user_id=request('user_id');
        $add_id=request('add_id');
        $is_default=request('is_default',0);
        if(empty($user_id)||empty($add_id)){return $this->Interface_error('参数错误');}
        //如果是设置默认信息 只能存在一个
        if($is_default==1){
             //去掉已经有的默认信息
            $old_info['is_default']=0;
             User::updateAddress([['user_id','=',$user_id],['is_default','=',1]],$old_info);
              //添加默认信息
            $new_info['is_default']=1;
            User::updateAddress([['user_id','=',$user_id],['id','=',$add_id]],$new_info);
        }else{
             //取消默认无所谓
            $default['is_default']=0;
            User::updateAddress([['user_id','=',$user_id],['id','=',$add_id]],$default);
        }
        return $this->Interface_success('修改成功');
    }

    /**
     * @return string
     * @name  删除收货地址信息
     * @author ihammer
     */
    public function DelUserAddress(){
        $user_id=request('user_id');
        $add_id=request('add_id');
        User::DelAddress([['id','=',$add_id],['user_id','=',$user_id]]);
        return $this->Interface_success('删除成功');
    }

    /**
     * @return string
     * @name 修改收货地址信息
     * @author ihammer
     */
    public function editUserAddress(){
        //采集数据
        $data['user_id']=request('user_id'); //  user_id:  add_id： consignee： mobile：
        $data['id']=request('add_id');
        $data['consignee']=request('consignee');//收货人信息
        $data['mobile']=request('mobile');//手机号
        $data['province']=request('province');//省份
        $data['city']=request('city');//城市
        $data['county']=request('county');//区县
        $data['detaile']=request('detaile');//详细地址
        $data['is_default']=request('is_default',0);//是否默认
        //验证不能为空
        foreach ($data as $key=>$val){if(empty($val)&&$key!='is_default'){return $this->Interface_error('参数错误！');}}
        //验证手机号
        if(!$this->checkMobile($data['mobile'])){
            return $this->Interface_error('手机号错误');
        }
        //变更数据
        User::updateAddress([['user_id','=',$data['user_id']],['id','=',$data['id']]],$data);
        return $this->Interface_success('添加成功');
    }
}