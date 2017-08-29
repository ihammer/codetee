<?php

namespace App\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    protected $table="users";

    /**
     * @return mixed
     * @name 获取地址列表
     * @author ihammer
     */
    public static function getAddressById($user_id){
        return DB::table('users_address')->where('user_id',$user_id)->orderBy('is_default','desc')->get();
    }

    /**
     * @param $data
     * @return mixed
     * @name  添加用户收货地址
     * @author ihammer
     */
    public static function Address($data){
        return DB::table('users_address')->insertGetid($data);
    }

    /**
     * @param $where
     * @param $data
     * @return mixed
     * @name 更改收货地址信息
     * @author ihammer
     */
    public static function updateAddress($where,$data){
        return DB::table('users_address')->where($where)->update($data);
    }

    /**
     * @param $where
     * @return mixed
     * @name 删除收货地址信息
     * @author ihammer
     */
    public static function DelAddress($where){
        return DB::table('users_address')->where($where)->delete();
    }

    /**
     * @param $add_id
     * @return mixed
     * @name 根据id获取地址信息
     * @author ihammer
     *
     */
    public static function getAddById($add_id){
        return DB::table('users_address')->where('id',$add_id)->first();
    }
}
