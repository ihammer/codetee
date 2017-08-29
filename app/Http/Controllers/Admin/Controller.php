<?php
/**
 * Created by PhpStorm.
 * User: xiaowu
 * Date: 2017/7/21
 * Time: 0:51
 * Name: 公共类
 */
namespace App\Http\Controllers\Admin;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
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
}


