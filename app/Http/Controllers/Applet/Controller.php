<?php
/**
 * Created by PhpStorm.
 * User: xiaowu
 * Date: 2017/7/21
 * Time: 0:51
 * Name: 公共类
 */
namespace App\Http\Controllers\Applet;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        //设置控制器
        $action =self::getCurrentAction();
        $controller=trim(substr($action['controller'],strrpos($action['controller'], '\\')),'\\');
        View::share('action',$controller);
    }

    /**
     * @return array
     * @name 获取控制i的方法
     * @author wudean
     */
    public static function getCurrentAction()
    {
        $action = Route::current()->getActionName();
        list($class, $method) = explode('@', $action);
        return ['controller' => $class, 'method' => $method];
    }

    //成功返回
    public function Interface_success($msg="成功",$data=[])
    {
        $newdata["status"] =200;
        $newdata['msg'] = $msg;
        $newdata["data"] = $data;
        return json_encode($newdata);
    }
    //----------就是分开写了---------/
    //失败返回
    public function Interface_error($msg="失败",$data=[],$status=400)
    {
        $newdata["status"] = $status;
        $newdata["data"] = $data;
        $newdata['msg'] = $msg;
        return json_encode($newdata);
    }

    //检查手机号是否正确
    public function checkMobile($mobile)
    {
        if (preg_match('/^(1(([35][0-9])|(47)|[7][0-9]|[8][0-9]))\d{8}$/', $mobile)) {
            //验证通过
            return true;
        } else {
            //手机号码格式不对
            return false;
        }
    }

    /**
     * @return string
     * @name 生成订单号
     * @author ihammer
     */
    public function CreateOrderNo(){
        return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }

    /**
     * @param $obj
     * @return mixed
     * @name 将对象递归转为数组
     * @author ihammer
     */
    public function object_to_array($obj)
    {
        $_arr = is_object($obj) ? get_object_vars($obj) : $obj;
        foreach ($_arr as $key => $val)
        {
            $val = (is_array($val) || is_object($val)) ? $this->object_to_array($val) : $val;
            $arr[$key] = $val;
        }
        return $arr;
    }
}


