<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/3
 * Time: 11:48
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Extend\Qiniu;
use App\Http\Controllers\PretreatmentController;
use App\Model\Order;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class OrderController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @name  获取已完成订单的列表
     * @author wudean
     */
    public function index(Request $request){
        $alreadyList=Order::getOrderList();
        foreach ($alreadyList as $akey=>$aval){
            $aval->order_info=json_decode($aval->order_info);
            $aval->model_content=json_decode($aval->model_content);
            $aval->order_func=PretreatmentController::PayMethod($aval->order_func);
            $aval->status_info=PretreatmentController::PayStatus($aval->status);
        }
        return view('admin.order.order_list',compact('alreadyList'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @name  二维码管理列表
     * @author wudean
     */
    public function QRCode(){
        $alreadyList=Order::getOrderList();
        foreach ($alreadyList as $akey=>$aval){
             $aval->model_content=json_decode($aval->model_content);
             $aval->status_info=PretreatmentController::PayStatus($aval->status);
              //二维码内容
             $url='http://'.$_SERVER['HTTP_HOST']."/api/qrcode/$aval->order_no/see_".uniqid();
             $aval->qrcont=$url;
        }
        return view('admin.order.code_list',compact('alreadyList'));
    }

    /**
     * @param $order_no
     * @return mixed
     * @name 生成二维码
     * @author wudean
     */
    public function QRCodeContent($order_no){
        $Order=Order::where('order_no',$order_no)->first();
        $size=empty(request('size'))?150:request('size');
        if(empty($Order)){
            return QrCode::encoding('UTF-8')->size(150)->generate("扫！扫！扫！扫你妹呀！...");
        }else{
            $url='http://'.$_SERVER['HTTP_HOST']."/api/qrcode/$Order->order_no/see_".uniqid();
            return QrCode::size($size)->generate("$url");
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @name 二维码修改
     * @author wudean
     */
    public function QRCodeEdit($id){
        $already=Order::getOrderBYId($id);
        return view('admin.order.code_edit',compact('already'));
    }
}
