<?php
/**
 * Created by PhpStorm.
 * User: Wudean
 * Date: 2017/8/14 0014
 * Time: 16:32
 * Name : 公共处理类
 */
namespace App\Http\Controllers\Applet;
use App\Http\Controllers\Extend\Qiniu;
use App\Model\Goods;

class CommonController extends Controller{

    /**
     * @return string
     * @name 上传接口
     * @author ihammer
     */
    public function UpLoad(){
        $tmpfile=request('file');
        if(empty($tmpfile)){
            return $this->Interface_error();
        }
        //处理展示图片
        $resource_img_info=Qiniu::uploadFile($tmpfile);
        if($resource_img_info['status']!=200){
            return $this->Interface_error();
        }else{
            return $this->Interface_success('成功',$resource_img_info['data']);
        }
    }

    /**
     * @return string
     * @name 城市三级联动列表
     * @author ihammer
     */
    public function regionList(){
        $regionlist=Goods::getRegionList();
        return $this->Interface_success('成功',$regionlist);
    }
}