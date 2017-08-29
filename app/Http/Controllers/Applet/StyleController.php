<?php
/**
 * Created by PhpStorm.
 * User: Wudean
 * Date: 2017/8/14 0014
 * Time: 16:32
 * Name : 关于 款式信息处理类
 */
namespace App\Http\Controllers\Applet;
use App\Model\Goods;
use Illuminate\Http\Request;

class StyleController extends Controller{
    /**
     * @param Request $request
     * @name  款式列表
     * @author  ihammer
     * @return  string
     */
   public function index(){
        $data=Goods::GetGoodsListIsCustom();
        if(empty($data)){return $this->Interface_error('信息错误');}
        return $this->Interface_success('成功',$data);
    }

    /**
     * @return string
     * @name  限量定制
     * @author ihammer
     */
    public function Limited(){
        $limited=Goods::where('is_custom',1)->first();
        return $this->Interface_success('成功',$limited);
    }
    /**
     * @param $style
     * @return string
     * @name 颜色列表
     * @author ihammer
     */
    public function getColorList($style_id){
        $colorList=Goods::getColorByGoodId($style_id);
        if(empty($colorList)){return $this->Interface_error('信息错误');}
        return $this->Interface_success('成功',$colorList);
    }

    /**
     * @param $color
     * @return string
     * @name  位置列表
     * @author ihammer
     */
    public function getPatternList($color_id){
        $patternList=Goods::getPatternByColorId($color_id);
        if(empty($patternList)){return $this->Interface_error('信息错误');}
        return $this->Interface_success('成功',$patternList);
    }

    /**
     * @param $style_id
     * @return string
     * @name 尺寸和大小的列表
     * @author ihammer
     */
    public function getSizeToTextureList($style_id){
        $style=Goods::find($style_id);
        if(empty($style)){return $this->Interface_error('信息错误');}
        //尺寸信息
        foreach (explode(',',$style->size) as $skey => $sval){
            $sizeInfo=Goods::GetSizeById($sval);
            $size[$skey]['id']=$sval;
            $size[$skey]['name']=$sizeInfo->name;
        }
        //大小信息
        foreach (explode(',',$style->texture) as $tkey=>$tval){
            $textureInfo=Goods::GetTextureById($tval);
            $texture[$tkey]['id']=$tval;
            $texture[$tkey]['name']=$textureInfo->name;
            $texture[$tkey]['description']=$textureInfo->description;
        }
        $data['size']=$size;
        $data['texture']=$texture;
        return $this->Interface_success('成功',$data);
    }
}