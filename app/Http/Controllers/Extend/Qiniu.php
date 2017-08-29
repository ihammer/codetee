<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/28 0028
 * Time: 18:46
 */
namespace App\Http\Controllers\Extend;
use Illuminate\Support\Facades\Storage;
use Qiniu\Storage\UploadManager;

class Qiniu{
    public static function uploadFileImage($file){
        //判断是否为空
        if(empty($file)){return false;}
        //获取后缀
        $ext=$file->getClientOriginalExtension();
        //检测后缀 --  目前来看这种检测方式别不是特别好
        $extArray=['jpg','png','gif'];
        if(!in_array($ext,$extArray)){
            return ['msg'=>'仅支持(jpg,png,gif)为后缀的文件', 'status'=>400, 'data'=>''];
        }
        //重建文件名字
        $fileName=date('YmdHis').'_'.uniqid().'.'.$ext;
        $disk=Storage::disk('qiniu');
        //处理上传
        $uploadMgr=new UploadManager();
        list($ret, $err)=$uploadMgr->putFile($disk->uploadToken($fileName), $fileName, $file->getRealPath());
        if(empty($err)){
            return ['msg'=>'上传成功', 'status'=>200, 'data'=>$fileName];
        }else{
            return ['msg'=>'上传失败', 'status'=>400, 'data'=>''];
        }
    }

    /**
     * @param $file
     * @return array|bool
     * @name 上传
     * @author ihammer
     */
    public static function uploadFile($file){
        //判断是否为空
        if(empty($file)){return false;}
        //获取后缀
        $ext=$file->getClientOriginalExtension();
        //重建文件名字
        $fileName=date('YmdHis').'_'.uniqid().'.'.$ext;
        $disk=Storage::disk('qiniu');
        //处理上传
        $uploadMgr=new UploadManager();
        list($ret, $err)=$uploadMgr->putFile($disk->uploadToken($fileName), $fileName, $file->getRealPath());
        if(empty($err)){
            return ['msg'=>'上传成功', 'status'=>200, 'data'=>$fileName];
        }else{
            return ['msg'=>'上传失败', 'status'=>400, 'data'=>''];
        }
    }
}
