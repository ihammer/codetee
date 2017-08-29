<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/3 0003
 * Time: 17:01
 * Name：预处理类
 * Author : wudean
 */

namespace App\Http\Controllers;


class PretreatmentController
{


    /**
     * @param $key
     * @return mixed
     * @name 支付方式
     */
    public static  function PayMethod($key){
        $data=[1=>'微信',2=>'支付宝',3=>'其他'];
        return $data[$key];
    }

    /**
     * @param $key
     * @return mixed
     * @Name 支付状态
     */
    public static function PayStatus($key){
        $data=[100=>'未支付',101=>'已取消',200=>'已支付',201=>'已退款',202=>'已收货',203=>'已发货'];
        if($data[$key]){
            return $data[$key];
        }else{
            return '---';
        }

    }
}