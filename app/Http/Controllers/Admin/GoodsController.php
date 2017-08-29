<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/27 0027
 * Time: 17:12
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Extend\Qiniu;
use App\Model\Goods;
use Illuminate\Http\Request;

class GoodsController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @name  款式列表
     * @author wudean
     */
    public function goods(){
        $goodsList=Goods::GetGoodsList();
        foreach ($goodsList as $gkey => $gval){
            $gval->images= $_ENV['QINIU_URL'].'/'.$gval->images.'?imageView2/0/w/50/h/50/q/75|imageslim';
            //PS : 以下内容一定要优化
            $size="";
            foreach (explode(',',$gval->size) as  $skey=>$sval ){
                    $sizeinfo=Goods::GetSizeById($sval);
                    $size.="&nbsp;&nbsp;".$sizeinfo->name;
            }
            $gval->size=$size;

            $texture="";
            foreach (explode(',',$gval->texture) as  $skey=>$sval ){
                $textureinfo=Goods::GetTextureById($sval);
                $texture.="&nbsp;&nbsp;".$textureinfo->name;
            }
            $gval->texture=$texture;
        }
        return  view('admin.goods.goods_list',compact('goodsList'));
    }

    /**
     * @param Request $request
     * @name  款式信息存储
     * @author wudean
     * @return  object
     */
    public function goodStore(Request $request){
        $this->validate(request(),[
            'name'=>'required',//姓名
            'title'=>'required',//标识 man /woman / body
            'images'=>'required',//展示照片
            'bg_image'=>'required',//背景照片
            'texture'=>'required|array',//材质
            'size'=>'required|array',//尺码
            'market_price'=>'required',//尺码
            'price'=>'required',//尺码
            'weight'=>'required|integer',//权重
            'description'=>'required',//描述
        ]);

        //检测是否存在数据
        $name=Goods::where([['name','=',request('name')]])->first();
        if($name){
            return back()->withErrors('款式名字重复了');
        }

        //处理展示图片
        $resource_img_info=Qiniu::uploadFileImage(request('images'));
        if($resource_img_info['status']!=200){
            return back()->withErrors($resource_img_info['msg']);
        }else{
            $images=$resource_img_info['data'];
        }

        //处理背景图片
        $resource_bg_info=Qiniu::uploadFileImage(request('bg_image'));
        if($resource_bg_info['status']!=200){
            return back()->withErrors($resource_bg_info['msg']);
        }else{
            $bg_image=$resource_bg_info['data'];
        }

        //整理数据
        $data['name']=request('name');
        $data['title']=request('title');
        $data['images']=$images;
        $data['bg_image']=$bg_image;
        $data['texture']=implode(',',request('texture'));
        $data['size']=implode(',',request('size'));
        $data['market_price']=request('market_price');
        $data['weight']=request('weight');
        $data['price']=request('price');
        $data['description']=request('description');
        $goodsinfo=Goods::GoodsCreate($data);
        return redirect('admin/goods');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @name  款式添加页面
     * @author wudean
     */
    public function goodCreate(){
        //材质列表
        $texturelist=Goods::TextureList();
        //尺码列表
        $sizelist=Goods:: SizeList();
        //渲染
        return view('admin.goods.goods_add',compact('texturelist','sizelist'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @name  款式编辑
     * @author wudean
     */
    public function goodEdit($id){
        //获取款式信息
        $goodInfo=Goods::where('id',$id)->first();
        $goodInfo->texture=explode(',',$goodInfo->texture);
        $goodInfo->size=explode(',',$goodInfo->size);
        $goodInfo->images=$_ENV['QINIU_URL'].'/'.$goodInfo->images."?imageView2/0/w/150/h/150/q/75|imageslim";
        $goodInfo->bg_image=$_ENV['QINIU_URL'].'/'.$goodInfo->bg_image."?imageView2/0/w/150/h/150/q/75|imageslim";
        //材质列表
        $texturelist=Goods::TextureList();
        //尺码列表
        $sizelist=Goods:: SizeList();
        return view('admin.goods.goods_edit',compact('texturelist','sizelist','goodInfo'));
    }

    /**
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @name 修改款式
     * @author wudean
     */
    public function goodStoreEdit($id){
        //验证信息
        $this->validate(request(),[
            'name'=>'required',//名称
            'title'=>'required',//名称
            'texture'=>'required|array',//材质
            'size'=>'required|array',//尺码
            'market_price'=>'required',//尺码
            'price'=>'required',//尺码
            'weight'=>'required|integer',//权重
            'description'=>'required',//描述
        ]);

        if(!empty(request('images'))){
                //处理展示图片
            $resource_img_info=Qiniu::uploadFileImage(request('images'));
            if($resource_img_info['status']!=200){
                return back()->withErrors($resource_img_info['msg']);
            }else{
                $images=$resource_img_info['data'];
            }
            $data['images']=$images;
        }
        if(!empty(request('bg_image'))) {
            //处理背景图片
            $resource_bg_info = Qiniu::uploadFileImage(request('bg_image'));
            if ($resource_bg_info['status'] != 200) {
                return back()->withErrors($resource_bg_info['msg']);
            } else {
                $bg_image = $resource_bg_info['data'];
            }
            $data['bg_image']=$bg_image;
        }
        //整理数据
        $data['name']=request('name');
        $data['title']=request('title');
        $data['texture']=implode(',',request('texture'));
        $data['size']=implode(',',request('size'));
        $data['market_price']=request('market_price');
        $data['weight']=request('weight');
        $data['price']=request('price');
        $data['description']=request('description');
        Goods::where('id',$id)->update($data);
        return redirect('admin/goods');
    }

    /**
     * @param $id
     * @param $status
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @name 款式上下架
     * @author wudean
     */
    public function goodsStatus($id,$status){
        if($status=='up'){
            $data['status']=1;
            Goods::where('id',$id)->update($data);
            return redirect('admin/goods');
        }else{
            $data['status']=0;
            Goods::where('id',$id)->update($data);
            return redirect('admin/goods');
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @name 获取款式颜色列表
     * @author wudean
     */
    public function Color(){
        //款式颜色列表
        $colorList=Goods::getColorList();
         //处理图片
        foreach ($colorList as $gkey => $gval){
            $gval->color_image= $_ENV['QINIU_URL'].'/'.$gval->color_image.'?imageView2/0/w/50/h/50/q/75|imageslim';
        }
        return view('admin.goods.color_list',compact('colorList'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @name 款式颜色创建页面
     * @author wudean
     */
    public function colorCreate(){
        $goodsList=Goods::GetGoodsList();
        return view('admin.goods.color_add',compact('goodsList'));
    }

    /**
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @name  款式颜色处理
     * @author wudean
     */
    public function colorStore(){
        //开始验证
        $this->validate(request(),[
            'good_id'=>'required',//商品id
            'color_name'=>'required',//颜色名称
            'color_title'=>'required',//标识
            'color_tone'=>'required',//颜色值
            'color_image'=>'required',// 图片
            'color_bg_image'=>'required',//背景图
            'color_weight'=>'required|integer',//权重
        ]);
        //颜色名称
        $colorInfo=Goods::getColorByGoodIdToVal(request('good_id'),request('color_name'));
        if($colorInfo){
            return back()->withErrors('该款式颜色名字重复了');
        }

        //处理展示图片
        $resource_img_info=Qiniu::uploadFileImage(request('color_image'));
        if($resource_img_info['status']!=200){
            return back()->withErrors($resource_img_info['msg']);
        }else{
            $color_image=$resource_img_info['data'];
        }

        //处理背景图片
        $resource_bg_info=Qiniu::uploadFileImage(request('color_bg_image'));
        if($resource_bg_info['status']!=200){
            return back()->withErrors($resource_bg_info['msg']);
        }else{
            $color_bg_image=$resource_bg_info['data'];
        }

        // 整合数据
        $data['good_id']=request('good_id');
        $data['color_name']=request('color_name');
        $data['color_title']=request('color_title');
        $data['color_tone']=request('color_tone');
        $data['color_bg_image']=$color_bg_image;
        $data['color_image']=$color_image;
        $data['color_weight']=request('color_weight');

        //添加数据
        $colorinfo=Goods::ColorCreate($data);
        return redirect('admin/color');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @name 编辑展示页面
     * @author wudean
     */
    public function colorEdit($id){
        $goodsList=Goods::GetGoodsList();
        $colorInfo=Goods::getColorById($id);
        $colorInfo->color_image=$_ENV['QINIU_URL'].'/'.$colorInfo->color_image."?imageView2/0/w/150/h/150/q/75|imageslim";
        $colorInfo->color_bg_image=$_ENV['QINIU_URL'].'/'.$colorInfo->color_bg_image."?imageView2/0/w/150/h/150/q/75|imageslim";
        return view('admin.goods.color_edit',compact('goodsList','colorInfo'));
    }

    /**
     * @param $good_id
     * @return string
     * @name  根据款式id获取款式颜色列表
     * @author wudean
     */
    public function getColorById($good_id){
        $list=Goods::getColorByGoodId($good_id);
        return $this->Interface_success('成功返回',$list);
    }

    public function colorStoreEdit($id){
        //开始验证
        $this->validate(request(),[
            'good_id'=>'required',//商品id
            'color_name'=>'required',//颜色名称
            'color_title'=>'required',//颜色名称
            'color_tone'=>'required',//颜色值
            'color_weight'=>'required|integer',//权重
        ]);
        if(!empty(request('color_image'))){
            //处理展示图片
            $resource_img_info=Qiniu::uploadFileImage(request('color_image'));
            if($resource_img_info['status']!=200){
                return back()->withErrors($resource_img_info['msg']);
            }else{
                $color_image=$resource_img_info['data'];
            }
            $data['color_image']=$color_image;
        }

        if(!empty(request('color_bg_image'))) {
            //处理背景图片
            $resource_bg_info = Qiniu::uploadFileImage(request('color_bg_image'));
            if ($resource_bg_info['status'] != 200) {
                return back()->withErrors($resource_bg_info['msg']);
            } else {
                $color_bg_image = $resource_bg_info['data'];
            }
            $data['color_bg_image']=$color_bg_image;
        }

        // 整合数据
        $data['good_id']=request('good_id');
        $data['color_name']=request('color_name');
        $data['color_title']=request('color_title');
        $data['color_tone']=request('color_tone');
        $data['color_weight']=request('color_weight');
        //添加数据
        Goods::ColorUpdate($id,$data);
        return redirect('admin/color');
    }

    public function colorDelete($id){
        Goods::ColorDelete($id);
        return redirect('admin/color');
    }
    /**
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @name 图案存储
     * @author  wudean
     */
    public function patternStore(){
        //开始验证
        $this->validate(request(),[
            'good_id'=>'required',//商品id
            'color_id'=>'required',//颜色id
            'pattern_name'=>'required',//图案位置
            'pattern_images'=>'required',// 图片
            'pattern_bg_image'=>'required',//背景图
            'pattern_weight'=>'required|integer',//权重
        ]);
        //处理展示图片
        $resource_img_info=Qiniu::uploadFileImage(request('pattern_images'));
        if($resource_img_info['status']!=200){
            return back()->withErrors($resource_img_info['msg']);
        }else{
            $pattern_images=$resource_img_info['data'];
        }

        //处理背景图片
        $resource_bg_info=Qiniu::uploadFileImage(request('pattern_bg_image'));
        if($resource_bg_info['status']!=200){
            return back()->withErrors($resource_bg_info['msg']);
        }else{
            $pattern_bg_image=$resource_bg_info['data'];
        }
        // 整合数据
        $data['good_id']=request('good_id');
        $data['color_id']=request('color_id');
        $data['pattern_name']=request('pattern_name');
        $data['pattern_bg_images']=$pattern_bg_image;
        $data['pattern_images']=$pattern_images;
        $data['pattern_weight']=request('pattern_weight');

        //添加数据
        $patterninfo=Goods::PatternCreate($data);
        return redirect('admin/pattern');

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @name 图案列表
     * @author wudean
     */
    public function pattern(){
        $pattern_list=Goods::getPatternList();
        //处理图片
        foreach ($pattern_list as $gkey => $gval){
            $gval->pattern_images= $_ENV['QINIU_URL'].'/'.$gval->pattern_images.'?imageView2/0/w/50/h/50/q/75|imageslim';
            $gval->pattern_title=Goods::getPatternPredefinedlist($gval->pattern_title);
        }
        return view('admin.goods.pattern_list',compact('pattern_list'));
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @name 创建列表
     * @author ihammer
     */
    public function patternCreate(){
        $goodsList=Goods::GetGoodsList();
        $patternList=Goods::getPatternPredefinedlist();
        return view('admin.goods.pattern_add',compact('goodsList','patternList'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @name  图案信息修改
     * @author  wudean
     */
    public function patternEdit($id){
        $goodsList=Goods::GetGoodsList();
        $patternInfo=Goods::getPatternById($id);
        $colorList=Goods::getColorByGoodToId($patternInfo->good_id);
        $patternInfo->pattern_images=$_ENV['QINIU_URL'].'/'.$patternInfo->pattern_images."?imageView2/0/w/150/h/150/q/75|imageslim";
        $patternInfo->pattern_bg_images=$_ENV['QINIU_URL'].'/'.$patternInfo->pattern_bg_images."?imageView2/0/w/150/h/150/q/75|imageslim";
        $patternList=Goods::getPatternPredefinedlist();
        return view('admin.goods.pattern_edit',compact('goodsList','patternInfo','colorList','patternList'));
    }

    public function patternStoreEdit($id){
        //开始验证
        $this->validate(request(),[
            'good_id'=>'required',//商品id
            'color_id'=>'required',//颜色id
            'pattern_name'=>'required',//图案位置
            'pattern_weight'=>'required|integer',//权重
        ]);
        if(!empty(request('pattern_images'))) {
            //处理展示图片
            $resource_img_info = Qiniu::uploadFileImage(request('pattern_images'));
            if ($resource_img_info['status'] != 200) {
                return back()->withErrors($resource_img_info['msg']);
            } else {
                $pattern_images = $resource_img_info['data'];
            }
            $data['pattern_images']=$pattern_images;
        }
        if(!empty(request('pattern_bg_image'))) {
            //处理背景图片
            $resource_bg_info = Qiniu::uploadFileImage(request('pattern_bg_image'));
            if ($resource_bg_info['status'] != 200) {
                return back()->withErrors($resource_bg_info['msg']);
            } else {
                $pattern_bg_image = $resource_bg_info['data'];
            }
            $data['pattern_bg_images']=$pattern_bg_image;
        }
        // 整合数据
        $data['good_id']=request('good_id');
        $data['color_id']=request('color_id');
        $data['pattern_name']=request('pattern_name');
        $data['pattern_title']=request('pattern_title');
        $data['pattern_weight']=request('pattern_weight');
        //更改数据
        Goods::PatternUpdate($id,$data);
        return redirect('admin/pattern');
    }

    public function patternDelete($id){
         Goods::patternDelete($id);
        return redirect('admin/pattern');
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @name 材质列表
     * @author wudean
     */
    public function Texture(){
        $txturelist=Goods::TextureList();
         return  view('admin.goods.texture_list',compact('txturelist'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @name 尺寸列表
     * @author  wudean
     */
    public function Size(){
        $sizelist=Goods::SizeList();
        return view('admin.goods.size_list',compact('sizelist'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @name 添加材质页面
     * @author wudean
     */
    public function textureCreate(){
        return view('admin.goods.texture_add');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @name 存储材质添加信息
     * @author wudean
     */
    public function textureStore(Request $request){
        $this->validate(request(),[
            'name'=>'required',
            'weight'=>'required|integer',
        ]);
        $data['name']=request('name');
        $data['weight']=request('weight');
        $data['description']=request('description');
         Goods::TextureCreate($data);
        return redirect('admin/texture');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @name 展示添加尺码页面
     * @author wudean
     */
    public function sizeCreate(){
        return view('admin.goods.size_add');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @name  尺码页面信息存储
     * @author wudean
     */
    public function sizeStore(){
        $this->validate(request(),[
            'name'=>'required',
            'weight'=>'required|integer',
        ]);
        $data['name']=request('name');
        $data['weight']=request('weight');
        Goods::SizeCreate($data);
        return redirect('admin/size');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @name  快递列表
     * @author wudean
     */
    public function Express(){
        $expresslist=Goods::ExpressList();
        return view('admin.goods.express_list',compact('expresslist'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @name  添加列表
     * @author wudean
     */
    public function ExpressCreate(){
        return view('admin.goods.express_add');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @name 存储快递信息
     * @author wudean
     */
    public function ExpressStore(){
        $this->validate(request(),[
            'name'=>'required',
            'price'=>'required|integer',
            'weight'=>'required|integer',
        ]);
        $data['name']=request('name');
        $data['price']=request('price');
        $data['weight']=request('weight');
        Goods::ExpressCreate($data);
        return redirect('admin/express');
    }
}
