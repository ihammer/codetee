<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;

class Goods extends Model
{
    protected $table="goods";

    /**
     * @return mixed
     * @name  款式列表
     * @author wudean
     */
    public static function GetGoodsList(){
         return DB::table('goods')->where([['status','!=',-1]])->paginate($_ENV['A_NUM']);
    }

    /**
     * @return mixed
     * @name 款式列表区分定制
     * @author wudean
     */
    public static function GetGoodsListIsCustom(){
        return DB::table('goods')->where([['status','!=',-1],['is_custom','=',0]])->get();
    }

    /**
     * @param $data
     * @return mixed
     * @nme 添加商品
     * @author wudean
     */
    public static function GoodsCreate($data){
        return DB::table('goods')->insertGetid($data);
    }

    /**
     * @param $good_id
     * @param $color_name
     * @return mixed
     * @name    根据商品id和款式颜色名称获取信息
     * @author wudean
     * @return  Object
     */
    public static function getColorByGoodIdToVal($good_id,$color_name){
        $where[]=['good_id','=',$good_id];
        $where[]=['color_name','=',$color_name];
        return DB::table('goods_color')->where($where)->first();
    }

    /**
     * @param $id
     * @return mixed
     * @name   根据id 获取信息
     * @author wudean
     */
    public static function getColorById($id){
        return DB::table('goods_color')->where('id',$id)->first();
    }
    /**
     * @return mixed
     * @name 获取款式颜色列表
     * @author wudean
     */
    public static function getColorList(){
        return DB::table('goods_color')
            ->join('goods','goods.id','=','goods_color.good_id')
            ->select('goods_color.*','goods.name')
            ->orderBy("goods_color.color_weight",'desc')
            ->paginate($_ENV['A_NUM']);
    }

    /**
     * @param $good_id
     * @return mixed
     * @name 根据商品id返回颜色列表
     * @author wudean
     */
    public static function getColorByGoodId($good_id){
        return DB::table('goods_color')->select('goods_color.id','goods_color.color_title','goods_color.color_name')->where('good_id',$good_id)->get();
    }

    /**
     * @param $data
     * @return mixed
     * @name 添加款式颜色数据
     * @author wudean
     */
    public static function ColorCreate($data){
        return DB::table('goods_color')->insertGetid($data);
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     * @name  更新数据
     * @author wudean
     */
    public static function ColorUpdate($id,$data){
        return DB::table('goods_color')->where('id',$id)->update($data);
    }

    /**
     * @param $id
     * @return mixed
     * @name 删除操作
     * @author wudean
     */
    public static function ColorDelete($id){
        return DB::table('goods_color')->where('id',$id)->delete();
    }

    /**
     * @param $good_id
     * @return mixed
     * @name  根据款式id获取颜色列表
     * @author wudean
     */
    public static function getColorByGoodToId($good_id){
        return DB::table('goods_color')->where('good_id',$good_id)->get();
    }

    /**
     * @return array
     * @name  返回预定义标识
     * @author ihammer
     */
    public static function getPatternPredefinedlist($title=""){
         $data=[
            'first'=>'前胸',//前
            'after'=>'后背',//后
            'first-left'=>'左胸',//前左
            'first-right'=>'右胸',//前右
            'arm-left'=>'左臂',//左臂
            'arm-right'=>'右臂',//右臂
            ];
         return empty($title)?$data:$data[$title];
    }

    /**
     * @param $data
     * @return mixed
     * @name 存储款式图案信息
     * @author wudean
     */
     public static function PatternCreate($data){
         return DB::table('goods_pattern')->insertGetid($data);
     }

    /**
     * @param $id
     * @return mixed
     * @name  根据id获取图案信息
     * @author wudean
     */
     public static function getPatternById($id){
            return DB::table('goods_pattern')->where('id',$id)->first();
     }
    /**
     * @return mixed
     * @name 图案列表
     * @author wudean
     */
     public static function getPatternList(){
              return DB::table('goods_pattern')
                  ->join('goods','goods.id','=','goods_pattern.good_id')
                  ->join('goods_color','goods_color.id','=','goods_pattern.color_id')
                  ->select('goods_pattern.*','goods.name as goods_name','goods_color.color_name')
                  ->orderBy("goods_color.color_weight",'desc')
                  ->paginate($_ENV['A_NUM']);
     }

    /**
     * @param $id
     * @param $data
     * @return mixed
     * @name 修改图案数据
     * @author wudean
     */
    public static function PatternUpdate($id,$data){
        return DB::table('goods_pattern')->where('id',$id)->update($data);
    }

    public static function patternDelete($id){
        return DB::table('goods_pattern')->where('id',$id)->delete();
    }

    /**
     * @param $color_id
     * @return mixed
     * @name 获取位置列表
     * @author  ihanmer
     */
    public static function getPatternByColorId($color_id){
        return DB::table('goods_pattern')->where('color_id',$color_id)->get();
    }

    /**
     * @return mixed
     * @name  材质列表
     * @author wudean
     * @description
     *  因为操作较少所以集合到Goods模型里面
     */
    public static function TextureList(){
        return DB::table('goods_texture')->get();
    }

    /**
     * @param $data
     * @return mixed
     * @nme 添加材质
     * @author wudean
     */
    public static function TextureCreate($data){
        return DB::table('goods_texture')->insertGetid($data);
    }

    /**
     * @param $id
     * @return mixed
     * @name  通过id获取一条材质信息
     * @author wudean
     */
    public static function GetTextureById($id){
        return DB::table('goods_texture')->where([['id','=',$id]])->first();
    }
        /**
     * @return mixed
     * @name 尺寸列表
     * @author wudean
     * @description
     *  因为操作较少所以集合到Goods模型里面
     */
    public static function SizeList(){
        return DB::table('goods_size')->get();
    }

    /**
     * @param $data
     * @return mixed
     * @name 存储添加尺码信息
     * @author wudean
     */
    public static function SizeCreate($data){
        return DB::table('goods_size')->insertGetid($data);
    }

    /**
     * @param $id
     * @return mixed
     * @name 根据id获取尺码信息
     * @author wudean
     */
    public static function GetSizeById($id){
        return DB::table('goods_size')->where([['id','=',$id]])->first();
    }
    /**
     * @return mixed
     * @name  快递列表
     * @author wudean
     * @description
     *  因为操作较少所以集合到Goods模型里面
     */
    public static function ExpressList(){
        return DB::table('express')->get();
    }

    /**
     * @param $data
     * @return mixed
     * @name 存储添加快递公司信息
     * @author wudean
     */
    public static function ExpressCreate($data){
        return DB::table('express')->insertGetid($data);
    }

    /**
     * @return mixed
     * @name  城市列表
     * @author ihammer
     * @description
     *     因为操作较少所以集合到Goods模型里面
     */
    public static function getRegionList(){
        return DB::table('region')->orderby('region_id','asc')->get();
    }

    /**
     * @param $pattern_id
     * @return mixed
     * @name 处理位置信息
     * @author ihammer
     */
    public static function getPatternAmassById($pattern_id){
        return DB::table('goods_pattern')
            ->where('goods_pattern.id',$pattern_id)
            ->join('goods','goods.id','=','goods_pattern.good_id')
            ->join('goods_color','goods_color.id','=','goods_pattern.color_id')
            ->select('goods_pattern.*','goods.name as goods_name','goods.name as price','goods.name as market_price','goods_color.color_tone','goods_color.color_name')
            ->first();
    }
}
