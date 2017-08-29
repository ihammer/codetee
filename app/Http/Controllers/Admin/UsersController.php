<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/26 0026
 * Time: 15:10
 */

namespace App\Http\Controllers\Admin;


use App\Model\User;
use App\Model\UsersAddress;
use Illuminate\Support\Facades\Request;

class UsersController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @name 用户列表
     * @author wudean
     */
    public function index(Request $request){
        $userlist=User::OrderBy('created_at','desc')->paginate($_ENV['A_NUM']);
        return view('admin.users.index',compact("userlist"));
    }

    /**
     * @param Request $request
     * @name 地址列表
     * @author  wudean
     * @return String
     */
    public function address($user_id){
         $userInfo=User::where([['id','=',$user_id]])->first();
         $addresslist=UsersAddress::where([['user_id','=',$user_id]])->OrderBy('id','desc')->paginate($_ENV['A_NUM']);
        return view('admin.users.address',compact("addresslist","userInfo"));
    }

}