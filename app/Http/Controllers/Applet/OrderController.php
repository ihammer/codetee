<?php
/**
 * Created by PhpStorm.
 * User: Wudean
 * Date: 2017/8/17 0014
 * Time: 16:32
 * Name : 关于订单i信息相关处理类
 */
namespace App\Http\Controllers\Applet;
use App\Model\Goods;
use App\Model\Order;
use App\Model\User;
use Illuminate\Http\Request;
class OrderController extends Controller{

    /**
     * @param null $key
     * @return mixed
     * @name 预定义方法
     * @author ihammer
     *
     */
    public static function Predefined($key=null){
        $data['packing']=15;//包装盒价格
        $data['freight']=15;//快递费
        return empty($key)?$data:$data[$key];
    }

    /**
     * @return string
     * @name  订单列表
     * @author  ihammer
     *
     */
    public function orderList(){
        $user_id=request('user_id');
        $data=Order::getOrderBYUserId($user_id);
        foreach ($data as $result){
            $result->order_info=json_decode($result->order_info);
            $result->model_content=json_decode($result->model_content);
            $result->distribution=json_decode($result->distribution);
        }
        return $this->Interface_success('成功',$data);
    }

    /**
     * @return string
     * @name 生成订单信息
     * @author ihammer
     */
    public function orderCreate(){
        //订单号
        $wx['order_no']=$this->CreateOrderNo();
        //用户id //user_id:用户id  pattern_id:位置id  size:尺码  texture:材质 amount:数量 model:模块 model_content:模块内容
        $wx['user_id']=request('user_id');
        //提交商品数据分配
        $pattern_id=request('pattern_id');
        $pat_info=Goods::getPatternAmassById($pattern_id);
        if(!$pat_info){
            return $this->Interface_error('位置信息错误！');
        }
        $info['color']=['color_name'=>$pat_info->color_name,'color_tone'=>$pat_info->color_tone,'color_id'=>$pat_info->color_id];
        $info['pattern']=['pattern_name'=>$pat_info->pattern_name,'pattern_id'=>$pat_info->id];
        $info['size']=request('size',0);
        $info['texture']=request('texture');
        $info['packing']=self::Predefined('packing');//包装盒价格
        $wx['goods_id']=$pat_info->good_id;//商品id
        $wx['order_info']=json_encode($info);//订单信息
        $wx['amount']=request('amount');//数量
        $wx['model']=request('model');//模块值
        $wx['model_content']=json_encode(request('model_content'));//模块内容
        $wx['freight']=self::Predefined('freight');//运费
        $wx['total']=$wx['freight']+($pat_info->price*$wx['amount'])+self::Predefined('packing');
        $wx['status']=100;
        //检索数据
        foreach ($wx as $val){if(empty($val)){return $this->Interface_error('参数不能为空！');}}
        //存储数据
        if($order_id=Order::AddOrderGetId($wx)){
            $data['order_id']=$order_id;
            return $this->Interface_success('成功！',$data);
        }else{
            return $this->Interface_error('操作失败！');
        }
    }

    /**
     * @param $order_id
     * @return string
     * @name 返回订单信息
     * @author ihammer
     */
    public function orderInfo($order_id){
        $order=Order::orderInfo($order_id);
        if(!$order){
            return $this->Interface_error('信息错误！');
        }
        $order->order_info=json_decode($order->order_info);
        return $this->Interface_success('成功',$this->object_to_array($order));
    }

    /**
     * @param $order_id
     * @return string
     * @name 填补订单数据
     * @author ihammer
     */
    public function orderGenerate($order_id){
        //获取地址id
        $add_id=request('add_id',1);
        $address=User::getAddById($add_id);
        if(!$address){return $this->Interface_error('信息错误！');}
        $addinfo['consignee']=$address->consignee;
        $addinfo['mobile']=$address->mobile;
        $addinfo['province']=$address->province;
        $addinfo['city']=$address->city;
        $addinfo['county']=$address->county;
        $addinfo['detaile']=$address->detaile;
        if($bool=Order::OrderUpdate($order_id,['distribution'=>json_encode($addinfo)])){
            return $this->Interface_success('修改成功！',['code'=>1]);
        }else{
            return $this->Interface_error('修改失败！',['code'=>0]);
        }
    }

}