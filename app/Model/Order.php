<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/3 0003
 * Time: 11:54
 */

namespace App\Model;
use Illuminate\Support\Facades\DB;
class Order extends Model
{
    protected $table="orders";

    /**
     * @return mixed
     * @name  返回已经完成订单列表
     * @author wudean
     */
    public static function getOrderList(){
         return DB::table('orders')
             ->join('goods','goods.id','=','orders.goods_id')
             ->join('users','users.id','=','orders.user_id')
             ->select('orders.*','goods.name as good_name','users.name as user_name')
             ->paginate($_ENV['A_NUM']);
    }

    /**
     * @param $id
     * @return mixed
     * @name  根据订单id获取一条订单信息
     * @author wudean
     */
    public static function getOrderBYId($id){
        return DB::table('orders')
            ->where('orders.id',$id)
            ->join('goods','goods.id','=','orders.goods_id')
            ->join('users','users.id','=','orders.user_id')
            ->select('orders.*','goods.name as good_name','users.name as user_name')
            ->first();
    }
    /**
     * @param $id
     * @return mixed
     * @name  根据用户d获取订单列表
     * @author wudean
     */
    public static function getOrderBYUserId($id){
        return DB::table('orders')
            ->where('orders.user_id',$id)
            ->join('goods','goods.id','=','orders.goods_id')
            ->join('users','users.id','=','orders.user_id')
            ->select('orders.*','goods.name as good_name','users.name as user_name')
            ->paginate($_ENV['A_NUM']);
    }

    /**
     * @param $data
     * @return mixed
     * @name 添加订单信息
     * @author ihammer
     */
    public static function addOrderGetId($data){
        return DB::table('orders')->insertGetid($data);
    }

    /**
     * @param $order_id
     * @param $user_id
     * @return mixed
     * @name 根据用户id/订单id获取订单信息
     * @author wudean
     */
    public static function orderInfo($order_id){
        return DB::table('orders')
            ->where('orders.id','=',$order_id)
            ->join('goods','goods.id','=','orders.goods_id')
            ->join('users','users.id','=','orders.user_id')
            ->select('orders.*','goods.name as good_name','goods.price as good_price','goods.market_price as good_market_price','users.name as user_name')
            ->first();
    }

    /**
     * @param $order_id
     * @param $data
     * @return mixed
     * @name 更新订单数据
     * @author ihammer
     */
    public static function OrderUpdate($order_id,$data){
        return DB::table('orders')->where('id',$order_id)->update($data);
    }
}