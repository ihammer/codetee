<?php
/**
 * Created by PhpStorm.
 * User: xiaowu
 * Date: 2017/7/21
 * Time: 1:04
 */

namespace App\Http\Controllers\Admin;


use App\Model\AdminPermission;

class PermissionController extends Controller
{
    //权限列表
    public function index(){
        $permissions=AdminPermission::paginate($_ENV['A_NUM']);
        return view('admin.permission.index',compact('permissions'));
    }
    //创建权限
    public function create(){
        return view('admin.permission.add');
    }
    //存储权限
    public function store(){
        $this->validate(request(),[
            'name'=>'required|min:3',
            'description'=>'required'
        ]);
        AdminPermission::create(request(['name','description']));
        return redirect('/admin/permissions');
    }
}