<?php
/**
 * Created by PhpStorm.
 * User: xiaowu
 * Date: 2017/7/21
 * Time: 1:04
 */

namespace App\Http\Controllers\Admin;


use App\Model\AdminPermission;
use App\Model\AdminRole;

class RoleController extends Controller
{
    //角色列表
    public function index(){
        $roles=AdminRole::paginate($_ENV['A_NUM']);
        return view('admin.role.index',compact('roles'));
    }
    //创建角色
    public function create(){
        return view('admin.role.add');
    }
    //创建角色
    public function store(){
        $this->validate(request(),[
            'name'=>'required|min:3',
            'description'=>'required'
        ]);
        AdminRole::create(request(['name','description']));
        return redirect('/admin/roles');
    }
    //角色的权限
    public function permission(AdminRole $role){
        $permissions=AdminPermission::all();
        $myPermissions=$role->permissions();
        return view('admin.role.permission',compact('permissions','myPermissions'));
    }
    //存储角色
    public function storePermission(AdminRole $role){
        $this->validate(request(),[
            'permissions'=>'required|array'
        ]);
        $permissions=AdminPermission::find(request('permissions'));
        $myPermissions=$role->permissions();

        // 对已经有的权限
        $addPermissions = $permissions->diff($myPermissions);
        foreach ($addPermissions as $permission) {
            $role->grantPermission($permission);
        }

        $deletePermissions = $myPermissions->diff($permissions);
        foreach ($deletePermissions as $permission) {
            $role->deletePermission($permission);
        }
        return back();
    }
}