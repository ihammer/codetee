<?php
/**
 * Created by PhpStorm.
 * User: xiaowu
 * Date: 2017/7/21
 * Time: 0:51
 * Name: 公共类
 */
namespace App\Http\Controllers\Web;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


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
        $ret = curl_exec($ch);
        return $ret;
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


