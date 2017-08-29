<?php
/**
 * Created by PhpStorm.
 * User: xiaowu
 * Date: 2017/7/21
 * Time: 1:04
 */

namespace App\Http\Controllers\Admin;


use App\Model\AdminRole;
use App\Model\AdminUser;
use Illuminate\Http\Request;

class AdminUsersController extends Controller
{
    //列表页面
    public function index(){
        $userlist=AdminUser::paginate($_ENV['A_NUM']);
        return view('admin.admin.index',compact('userlist'));
    }
    //创建页面
    public function create(){
        return view('admin.admin.create');
    }
    // 创建后台用户
    public function store(Request $request){
        $this->validate(request(),[
            'name'=>'required|min:3|max:8',
            'email'=>'required|email',
            'password' => 'required|min:5|max:16',
        ]);
        $name = request('name');
        $email = request('email');
        $password = bcrypt(request('password'));
        AdminUser::create(compact('name','email' ,'password'));
        return redirect('admin/admin_users');
    }

    //角色权限
    public function role(AdminUser $user){
        $roles=AdminRole::all();
        $myRoles=$user->roles();
        return view('admin.admin.role',compact('roles','myRoles','user'));
    }

    //角色存储
    public function storeRole(AdminUser $user){

        $this->validate(request(),['roles'=>'required|array']);

        $roles=AdminRole::find(request('roles'));
        $myRoles=$user->roles();

        //对已经有的权限
        $addRoles=$roles->diff($myRoles);
        foreach ($addRoles as $role){
            $user->roles()->save($role);
        }

        $deleteRoles=$myRoles->diff($roles);
        foreach ($deleteRoles as $role){
            $user->deleteRole($role);
        }
        return back();
    }
}