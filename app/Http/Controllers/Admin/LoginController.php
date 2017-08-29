<?php
/**
 * Created by PhpStorm.
 * User: xiaowu
 * Date: 2017/7/21
 * Time: 0:53
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @name 登陆首页
     * @author wudean
     */
    public function index(){
        return view('admin.login.index');
    }

    /**
     * @name 提交数据
     */
    public function login(Request $request){
        $this->validate(request(),[
            'name'=>'required|min:2',
            'password'=>'required|min:6|max:30',
        ]);
        $user=request(['name','password']);
        if(true==\Auth::guard('admin')->attempt($user)){
            return redirect('/admin/home');
        }
        return \Redirect::back()->withErrors("用户名密码错误");
    }

    /**
     * @author wudean
     * @name 退出
     */
    public function logout(){
        \Auth::guard('admin')->logout();
        request()->session()->flush();
        request()->session()->regenerate();
        return redirect('admin/login');
    }
}